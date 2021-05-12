@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Upload') }}</div>

                <div class="card-body">
                    <div id="output" class="container"></div>
                    <form role="form" class="form" onsubmit="return false;">
                        <div class="form-group">
                            <label for="uploadFile">Dosya Seç</label>
                            <input type="file" id="uploadFile" class="form-control-file">
                        </div>
                        <button type="submit" id="uploadBtn" class="btn btn-outline-primary">Yükle!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
    <script>
        (function () {
            var output = document.getElementById('output');
            document.getElementById('uploadBtn').onclick = function () {
                var data = new FormData();
                data.append('userId', '1');
                data.append('uploadFile', document.getElementById('uploadFile').files[0]);

                var config = {
                    headers:{'Content-Type': 'multipart/form-data'},
                    onUploadProgress: function(progressEvent) {
                        var percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                    }
                };

                axios.post('http://proje.com/api/upload', data, config)
                    .then(function (res) {
                        output.className = 'container';
                        output.innerHTML = res.data.url;
                    })
                    .catch(function (err) {
                        output.className = 'container text-danger';
                        output.innerHTML = err.message;
                    });
            };
        })();
    </script>
@endsection
