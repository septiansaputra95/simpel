<?php

namespace App\Http\Controllers\Scheduler;

use App\Http\Controllers\Controller;
use App\Models\MScheduledTask;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class SchedulerController extends Controller
{
    public function index()
    {
        return view('scheduler.index');
    }

    public function loadDatatables(): JsonResponse
    {
        $data = MScheduledTask::query()
            ->orderByDesc('scheduled_at')
            ->get()
            ->map(function (MScheduledTask $task) {
                return [
                    'id' => $task->id,
                    'action_type' => $task->action_type,
                    'payload' => $task->payload,
                    'scheduled_at' => $task->scheduled_at
                        ? $task->scheduled_at->copy()->setTimezone('Asia/Jakarta')->format('d/m/Y H:i')
                        : null,
                    'scheduled_at_input' => $task->scheduled_at
                        ? $task->scheduled_at->copy()->setTimezone('Asia/Jakarta')->format('Y-m-d\\TH:i')
                        : null,
                    'status' => $task->status,
                    'created_by' => $task->created_by,
                ];
            });

        return response()->json(['data' => $data]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'action_type' => ['required', 'string', Rule::in(['HOLD', 'RESET'])],
            'payload' => ['required', 'string'],
            'scheduled_at' => ['required', 'date_format:Y-m-d\\TH:i'],
        ], [
            'scheduled_at.date_format' => 'Tanggal dan jam harus menggunakan format yang valid.',
        ]);

        $validator->after(function ($validator) use ($request) {
            $payload = $request->input('payload');
            if (! is_string($payload)) {
                return;
            }

            try {
                json_decode($payload, false, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $exception) {
                $validator->errors()->add('payload', 'Payload harus berisi JSON yang valid.');
                return;
            }

        });

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $attributes = $validator->validated();
        $task = MScheduledTask::create([
            'action_type' => $attributes['action_type'],
            'payload' => json_decode($attributes['payload']),
            'scheduled_at' => Carbon::createFromFormat(
                'Y-m-d\\TH:i',
                $attributes['scheduled_at'],
                'Asia/Jakarta'
            )->setTimezone(config('app.timezone')),
            'created_by' => (string) $request->user()->username,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal berhasil disimpan.',
            'data' => ['id' => $task->id],
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $attributes = $request->validate([
            'status' => ['required', 'string', Rule::in(['CANCEL'])],
        ]);

        $cancelled = DB::transaction(function () use ($id, $attributes) {
            $task = MScheduledTask::query()->whereKey($id)->lockForUpdate()->firstOrFail();

            if ($task->status !== 'PENDING') {
                return false;
            }

            $task->status = $attributes['status'];
            $task->save();

            return true;
        });

        if (! $cancelled) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hanya jadwal berstatus PENDING yang dapat dibatalkan.',
            ], 409);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal berhasil dibatalkan. Silakan buat jadwal baru jika perlu menginput ulang.',
        ]);
    }
}
