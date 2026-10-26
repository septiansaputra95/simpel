$(function () {
    const $form = $('#scheduler-form');
    const $table = $('#tabel-scheduler');
    const $actionType = $('#action_type');
    const $payload = $('#payload');
    const $scheduledAt = $('#scheduled_at');
    const $status = $('#task-status');
    const $statusControl = $('#status-control');
    const $summary = $('#schedule-summary');
    const $message = $('#form-message');
    const $submit = $('#btn-simpan');
    let editingId = null;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    const escapeHtml = (value) => $('<div>').text(value ?? '').html();

    const formatWibInput = (date) => {
        const parts = [date.getUTCFullYear(), String(date.getUTCMonth() + 1).padStart(2, '0'), String(date.getUTCDate()).padStart(2, '0')];
        const time = [String(date.getUTCHours()).padStart(2, '0'), String(date.getUTCMinutes()).padStart(2, '0')];
        return `${parts[0]}-${parts[1]}-${parts[2]}T${time[0]}:${time[1]}`;
    };

    const refreshSummary = () => {
        const action = $actionType.val().trim();
        const schedule = $scheduledAt.val();
        if (!action && !schedule) {
            $summary.text('Lengkapi action, payload, dan waktu jadwal.');
            return;
        }
        const when = schedule ? schedule.replace('T', ' ') : 'belum ditentukan';
        $summary.text(`${action || 'Action belum diisi'} · ${when} WIB`);
    };

    const validatePayload = () => {
        const value = $payload.val().trim();
        try {
            JSON.parse(value);
            $('#payload-status')
                .text('JSON valid.')
                .removeClass('text-rose-600')
                .addClass('text-green-600');
            return true;
        } catch (error) {
            $('#payload-status').text('JSON belum valid.').removeClass('text-green-600').addClass('text-rose-600');
            return false;
        }
    };

    const showMessage = (message, success = false) => {
        $message
            .removeClass('hidden bg-green-50 text-green-700 bg-red-50 text-red-700')
            .addClass(success ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700')
            .text(message);
    };

    const table = $table.DataTable({
        processing: true,
        serverSide: false,
        paging: true,
        pageLength: 10,
        lengthChange: false,
        searching: true,
        ordering: false,
        autoWidth: false,
        language: {
            emptyTable: 'Belum ada jadwal.',
            info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ jadwal',
            infoEmpty: 'Belum ada jadwal',
            search: 'Cari:',
            zeroRecords: 'Jadwal tidak ditemukan.',
            loadingRecords: 'Memuat jadwal...',
            paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
        },
        ajax: { url: window.schedulerUrls.datatables, type: 'GET' },
        columns: [
            {
                data: 'action_type',
                render: (data) => `<span class="font-semibold text-ink">${escapeHtml(data)}</span>`,
            },
            {
                data: 'payload',
                render: (data) => {
                    const text = JSON.stringify(data ?? {}, null, 0);
                    return `<code class="block max-w-[220px] truncate rounded bg-slate-50 px-2 py-1 text-xs text-slate-500" title="${escapeHtml(text)}">${escapeHtml(text)}</code>`;
                },
            },
            { data: 'scheduled_at', render: (data) => escapeHtml(data || '—') },
            {
                data: 'status',
                render: (data) => `<span class="rounded-full bg-amber-bg px-2.5 py-1 text-xs font-semibold text-amber">${escapeHtml(data || 'PENDING')}</span>`,
            },
            { data: 'created_by', render: (data) => escapeHtml(data || '—') },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: (data, type, row) => row.status === 'PENDING'
                    ? `<button type="button" class="btn-edit-scheduler rounded-lg border border-bd px-3 py-1.5 text-xs font-semibold text-blue hover:bg-blue-bg" data-id="${escapeHtml(row.id)}">Edit</button>`
                    : '<span class="text-slate-300">—</span>',
            },
        ],
    });

    const setCreateMode = (clearMessage = true) => {
        editingId = null;
        $form[0].reset();
        $payload.val('{}').prop('readonly', false);
        $actionType.prop('disabled', false);
        $scheduledAt.prop('disabled', false);
        $status.val('PENDING').prop('disabled', true);
        $statusControl.addClass('hidden');
        $('#form-title').text('Buat Jadwal');
        $('#btn-simpan').text('Simpan Jadwal');
        $('#btn-reset').text('Reset');
        $('#btn-format-json, #btn-minify-json, #btn-clear-json, .time-preset').show();
        if (clearMessage) $message.addClass('hidden').text('');
        validatePayload();
        refreshSummary();
    };

    const setEditMode = (row) => {
        if (!row || row.status !== 'PENDING') return;

        editingId = row.id;
        $actionType.val(row.action_type).prop('disabled', true);
        $payload.val(JSON.stringify(row.payload ?? {}, null, 2)).prop('readonly', true);
        $scheduledAt.val(row.scheduled_at_input || '').prop('disabled', true);
        $status.val('PENDING').prop('disabled', false);
        $statusControl.removeClass('hidden');
        $('#form-title').text(`Ubah Status Jadwal #${row.id}`);
        $('#btn-simpan').text('Batalkan Jadwal');
        $('#btn-reset').text('Kembali');
        $('#btn-format-json, #btn-minify-json, #btn-clear-json, .time-preset').hide();
        $message.addClass('hidden').text('');
        validatePayload();
        refreshSummary();
        document.getElementById('scheduler-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    $('#tabel-scheduler').on('click', '.btn-edit-scheduler', function () {
        const row = table.row($(this).closest('tr')).data();
        setEditMode(row);
    });

    $('#btn-format-json').on('click', () => {
        try {
            $payload.val(JSON.stringify(JSON.parse($payload.val()), null, 2));
            validatePayload();
        } catch (error) {
            showMessage('Payload tidak dapat diformat karena JSON belum valid.');
        }
    });

    $('#btn-minify-json').on('click', () => {
        try {
            $payload.val(JSON.stringify(JSON.parse($payload.val())));
            validatePayload();
        } catch (error) {
            showMessage('Payload tidak dapat diminify karena JSON belum valid.');
        }
    });

    $('#btn-clear-json').on('click', () => {
        $payload.val('');
        validatePayload();
        $payload.trigger('focus');
    });

    $('.time-preset').on('click', function () {
        const minutes = Number($(this).data('minutes'));
        const wibNow = new Date(Date.now() + (7 * 60 * 60 * 1000));
        wibNow.setUTCMinutes(wibNow.getUTCMinutes() + minutes);
        $scheduledAt.val(formatWibInput(wibNow)).trigger('input');
    });

    $actionType.add($scheduledAt).on('input change', refreshSummary);
    $payload.on('input', validatePayload);

    $('#btn-reset').on('click', () => setCreateMode());

    $('#btn-refresh').on('click', () => table.ajax.reload());

    $form.on('submit', async function (event) {
        event.preventDefault();
        $message.addClass('hidden').text('');

        if (!this.reportValidity()) return;

        if (editingId !== null) {
            if ($status.val() !== 'CANCEL') {
                showMessage('Pilih status CANCEL untuk membatalkan jadwal.');
                return;
            }
            if (!window.confirm('Batalkan jadwal ini? Data action, payload, dan waktu tidak akan diubah.')) return;

            $submit.prop('disabled', true).text('Membatalkan...');
            try {
                const updateUrl = window.schedulerUrls.update.replace('__ID__', encodeURIComponent(editingId));
                const response = await axios.post(updateUrl, { status: 'CANCEL' }, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                });

                setCreateMode(false);
                showMessage(response.data.message || 'Jadwal berhasil dibatalkan.', true);
                table.ajax.reload(null, false);
            } catch (error) {
                const response = error.response?.data;
                const firstValidationError = response?.errors
                    ? Object.values(response.errors).flat()[0]
                    : null;
                showMessage(firstValidationError || response?.message || 'Jadwal gagal dibatalkan.');
            } finally {
                $submit.prop('disabled', false).text(editingId !== null ? 'Batalkan Jadwal' : 'Simpan Jadwal');
            }
            return;
        }

        if (!validatePayload()) {
            showMessage('Periksa kembali format payload JSON.');
            return;
        }

        let payload;
        try {
            payload = JSON.parse($payload.val());
        } catch (error) {
            showMessage('Periksa kembali format payload JSON.');
            return;
        }

        $submit.prop('disabled', true).text('Menyimpan...');
        try {
            const response = await axios.post(window.schedulerUrls.store, {
                action_type: $actionType.val().trim(),
                payload: JSON.stringify(payload),
                scheduled_at: $scheduledAt.val(),
            }, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            });

            showMessage(response.data.message || 'Jadwal berhasil disimpan.', true);
            $form[0].reset();
            $payload.val('{}');
            validatePayload();
            refreshSummary();
            table.ajax.reload(null, false);
        } catch (error) {
            const response = error.response?.data;
            const firstValidationError = response?.errors
                ? Object.values(response.errors).flat()[0]
                : null;
            showMessage(firstValidationError || response?.message || 'Jadwal gagal disimpan. Periksa koneksi dan coba lagi.');
        } finally {
            $submit.prop('disabled', false).text('Simpan Jadwal');
        }
    });

    validatePayload();
    refreshSummary();
});
