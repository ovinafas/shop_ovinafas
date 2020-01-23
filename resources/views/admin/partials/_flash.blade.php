@if (session('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button class="close" type="button" data-dismiss="alert">×</button>
        <strong>Error!</strong> {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button class="close" type="button" data-dismiss="alert">×</button>
        <strong>Success!</strong> {{ session('success') }}
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info alert-dismissible" role="alert">
        <button class="close" type="button" data-dismiss="alert">×</button>
        <strong>Info!</strong> {{ session('info') }}
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button class="close" type="button" data-dismiss="alert">×</button>
        <strong>Warning!</strong> {{ session('warning') }}
    </div>
@endif


@if ($errors->any())
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button class="close" type="button" data-dismiss="alert">×</button>
        <strong>Holy smokes!</strong> Something seriously bad happened!
    </div>
@endif