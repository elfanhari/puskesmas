@if (session()->has('success'))
  <script>
    iziToast.success({
    // title: 'Hey',
    message: '{{ session('success') }}',
    position: 'topRight',
    resetOnHover: false,
    progressBar: false,
    timeout: 5000,
  });
  </script>
@elseif (session()->has('info'))
  <script>
    iziToast.info({
    // title: 'Hey',
    message: '{{ session('info') }}',
    position: 'topRight',
    resetOnHover: false,
    progressBar: false,
    timeout: 5000,
  });
  </script>
@elseif (session()->has('warning'))
  <script>
    iziToast.warning({
    // title: 'Hey',
    message: '{{ session('warning') }}',
    position: 'topRight',
    resetOnHover: false,
    progressBar: false,
    timeout: 5000,
  });
  </script>
@elseif (session()->has('error'))
  <script>
    iziToast.error({
    // title: 'Hey',
    message: '{{ session('error') }}',
    position: 'topRight',
    resetOnHover: false,
    progressBar: false,
    timeout: 5000,
  });
  </script>
@endif
