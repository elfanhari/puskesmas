<div class="modal fade" tabindex="-1" role="dialog" id="modal-logout">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Logout</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah anda yakin akan keluar dari Aplikasi?
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-primary btn-submit">Ya, keluar</button>
        </form>
      </div>
    </div>
  </div>
</div>
