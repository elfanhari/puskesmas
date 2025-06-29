<script>
    let index = {{ count(old('items', $permintaan->itemPermintaanBarangs ?? [null])) }};

    // Init select2 dan trigger satuan
    function initRowSelect2() {
        $('.select2').select2({
            width: '100%'
        });

        $('.select-barang').off('change').on('change', function() {
            const satuan = $(this).find(':selected').data('satuan') ?? '';
            $(this).closest('tr').find('.satuan-text').text(satuan);
        });

        // Trigger awal satuan di semua baris
        $('.select-barang').each(function() {
            const satuan = $(this).find(':selected').data('satuan') ?? '';
            $(this).closest('tr').find('.satuan-text').text(satuan);
        });
    }

    initRowSelect2();

    $('#btn-add-item').on('click', function() {
        let row = `
      <tr>
        <td>
          <select name="items[${index}][barang_id]" class="form-control select-barang" required>
            <option value="">Pilih Barang</option>
            @foreach ($barangs as $barang)
              <option value="{{ $barang->id }}" data-satuan="{{ $barang->satuan }}">{{ $barang->nama }}</option>
            @endforeach
          </select>
        </td>
        <td class="d-flex">
          <input type="number" name="items[${index}][jumlah]" class="form-control mt-2" min="1" required>
        </td>
        <td>
          <span class="ml-2 satuan-text align-self-center">-</span>
        </td>
        <td class="text-center">
          <button type="button" class="btn btn-sm btn-danger btn-remove-item"><i class="fas fa-trash"></i></button>
        </td>
      </tr>
    `;
        $('#table-items tbody').append(row);
        index++;
        initRowSelect2();
    });

    $(document).on('click', '.btn-remove-item', function() {
        $(this).closest('tr').remove();
    });
</script>
