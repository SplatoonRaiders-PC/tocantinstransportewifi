<?php

namespace App\Services;

use App\Models\WhatsappSetting;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Sleep;

/**
 * Regras de envio dos lembretes de PIX não pago (automático e manual).
 *
 * Protegem o número contra denúncia/ban sem mudar quem recebe (continua
 * exigindo autorização e respeitando PARAR):
 *  - não envia de madrugada (horário de silêncio configurável);
 *  - limita o total de lembretes por dia;
 *  - espera um tempo aleatório entre um envio e outro (ritmo humano).
 */
class WhatsappSendPolicy
{
    public const DEFAULT_QUIET_START = 22; // não envia a partir das 22h...
    public const DEFAULT_QUIET_END = 7;    // ...até as 7h
    public const DEFAULT_DAILY_CAP = 30;

    public static function quietStartHour(): int
    {
        return self::hour(WhatsappSetting::get('quiet_start_hour'), self::DEFAULT_QUIET_START);
    }

    public static function quietEndHour(): int
    {
        return self::hour(WhatsappSetting::get('quiet_end_hour'), self::DEFAULT_QUIET_END);
    }

    public static function dailyCap(): int
    {
        return max(1, (int) WhatsappSetting::get('daily_reminder_cap', self::DEFAULT_DAILY_CAP));
    }

    /** Está no horário de silêncio? Janela pode atravessar a meia-noite (ex.: 22h–7h). */
    public static function isQuietTime(?CarbonInterface $now = null): bool
    {
        $hour = ($now ?? now())->hour;
        $start = self::quietStartHour();
        $end = self::quietEndHour();

        if ($start === $end) {
            return false; // sem horário de silêncio
        }

        return $start > $end
            ? ($hour >= $start || $hour < $end)
            : ($hour >= $start && $hour < $end);
    }

    public static function quietLabel(): string
    {
        return sprintf('%02dh às %02dh', self::quietStartHour(), self::quietEndHour());
    }

    public static function remindersSentToday(): int
    {
        return (int) Cache::get(self::counterKey(), 0);
    }

    public static function remainingToday(): int
    {
        return max(0, self::dailyCap() - self::remindersSentToday());
    }

    /** Conta um lembrete enviado (inclusive falhas: a tentativa já expôs o número). */
    public static function recordReminder(): void
    {
        $key = self::counterKey();
        Cache::add($key, 0, now()->addDays(2));
        Cache::increment($key);
    }

    /** Pausa aleatória entre envios, para não parecer disparo automático em massa. */
    public static function pauseBetweenSends(int $minSeconds, int $maxSeconds): void
    {
        Sleep::for(random_int($minSeconds, $maxSeconds))->seconds();
    }

    private static function counterKey(): string
    {
        return 'whatsapp_reminders_sent_'.now()->toDateString();
    }

    private static function hour($value, int $default): int
    {
        return is_numeric($value) && (int) $value >= 0 && (int) $value <= 23 ? (int) $value : $default;
    }
}
