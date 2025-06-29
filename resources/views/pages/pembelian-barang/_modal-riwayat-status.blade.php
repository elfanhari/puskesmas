<div class="modal fade" tabindex="-1" role="dialog" id="modal-riwayat-status">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Riwayat Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                @forelse ($pembelian->logPembelianBarang->sortBy('created_at') as $log)
                    <div class="d-flex align-items-start mb-4">
                        <div class="mr-3">
                            <i class="fas fa-circle text-{{ \App\Helpers\Utilities::getStatusColor($log->status) }}"></i>
                        </div>
                        <div>
                            <strong class="d-block">
                                {{ \App\Helpers\Utilities::getStatusLabel($log->status) }}
                            </strong>
                            <small class="text-muted">
                                {{ $log->created_at->format('d M Y H:i') }}
                            </small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada riwayat status.</p>
                @endforelse

            </div>
        </div>
    </div>
</div>
