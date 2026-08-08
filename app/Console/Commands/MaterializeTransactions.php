<?php

namespace App\Console\Commands;

use App\Models\TransactionSeries;
use App\Services\RecurrenceService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Throwable;

class MaterializeTransactions extends Command
{
    protected $signature = 'transactions:materialize
                            {--until= : Data limite das ocorrências, no formato YYYY-MM-DD}
                            {--months= : Quantidade de meses a projetar a partir de hoje}';

    protected $description = 'Gera ocorrências futuras para as séries de transações ativas';

    public function handle(RecurrenceService $recurrence): int
    {
        try {
            $until = $this->until($recurrence);
        } catch (Throwable $exception) {
            $this->components->error($exception->getMessage());

            return self::FAILURE;
        }

        $seriesCount = 0;
        $occurrenceCount = 0;

        TransactionSeries::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->chunkById(100, function ($seriesChunk) use ($recurrence, $until, &$seriesCount, &$occurrenceCount): void {
                foreach ($seriesChunk as $series) {
                    $before = $series->occurrences()->count();
                    $recurrence->materialize($series, $until);
                    $after = $series->occurrences()->count();
                    $seriesCount++;
                    $occurrenceCount += $after - $before;
                }
            });

        $this->components->info("{$occurrenceCount} ocorrência(s) criada(s) em {$seriesCount} série(s) ativa(s) até {$until->toDateString()}.");

        return self::SUCCESS;
    }

    private function until(RecurrenceService $recurrence): Carbon
    {
        if ($this->option('until') && $this->option('months')) {
            throw new \InvalidArgumentException('Use apenas uma das opções --until ou --months.');
        }

        if ($this->option('until')) {
            return Carbon::parse($this->option('until'))->endOfDay();
        }

        if ($this->option('months') !== null) {
            $months = filter_var($this->option('months'), FILTER_VALIDATE_INT);
            if ($months === false || $months < 0 || $months > 120) {
                throw new \InvalidArgumentException('A opção --months deve ser um inteiro entre 0 e 120.');
            }

            return $recurrence->defaultUntil($months);
        }

        return $recurrence->defaultUntil();
    }
}
