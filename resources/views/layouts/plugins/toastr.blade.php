@push('css')
<link rel="stylesheet" href="{{asset('css/toastr.min.css')}}" />
<style>
    #toast-container > div {
        opacity:1;
        margin-top: 50px;
    }
</style>
@endpush
@push('scripts')
<script type="text/javascript" src="{{asset('js/toastr.min.js')}}"></script>
@endpush