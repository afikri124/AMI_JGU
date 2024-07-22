@extends('layouts.master')
@section('title', 'Auditor Standard')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('style')
<style>
    .input-validation-error~.select2 .select2-selection {
        border: 1px solid red;
    }
</style>
@endsection

@section('breadcrumb-title')
<!-- <h3>User Profile</h3> -->
@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
<div class="row">
    <div class="col-md-12">
      <form class="card" action="{{ route('update_std', $data->id) }}"  method="POST" enctype="multipart/form-data">
        @csrf
            <div class="card-header">
                <h3 class="card-header"><b>Create Auditor Standard</b></h3>
                <hr class="my-0">
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <label for="auditor_id" class="form-label"><b>Auditor</b><i class="text-danger">*</i></label>
                            <select name="auditor_id" id="auditor_id" class="form-select select2" @readonly(true)>
                            <option value="">Select Auditor</option>
                            @foreach($auditor as $role)
                                <option value="{{$role->id}}" {{ $data->auditor_id ? 'selected' : '' }}>
                                    {{$role->name}}</option>
                                @endforeach
                            </select>
                    </div>
                    <p></p>
                  <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="standard_category_id" class="form-label"><b>Category</b><i class="text-danger">*</i></label>
                            <select name="standard_category_id[]" id="standard_category_id" class="form-select select2" multiple required>
                                @foreach($category as $c)
                                <option value="{{ $c->id }}" {{ in_array($c->id, old('standard_category_id', [])) ? 'selected' : '' }}>
                                    {{ $c->id }} - {{ $c->description }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="standard_criteria_id" class="form-label"><b>Criteria</b><i class="text-danger">*</i></label>
                            <select name="standard_criteria_id[]" id="standard_criteria_id" class="form-select select2" multiple required>
                                @foreach($criteria as $c)
                                    <option value="{{ $c->id }}" {{ in_array($c->id, old('standard_criteria_id', [])) ? 'selected' : '' }}>
                                        {{ $c->id }} - {{ $c->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary" type="submit">Create</button>
                <a href="{{ url()->previous() }}">
                    <span class="btn btn-secondary">Back</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });
    });
</script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#standard_category_id').select2({
            placeholder: " Select Category",
            allowClear: true
        });
        $('#standard_criteria_id').select2({
            placeholder: " Select Criteria",
            allowClear: true
        });

        // // Fungsi untuk menonaktifkan opsi yang sudah dipilih
        function disableSelectedOptions() {
            $('#standard_criteria_id option').each(function() {
                if ($(this).is(':selected')) {
                    $(this).attr('disabled', 'disabled');
                } else {
                    $(this).removeAttr('disabled');
                }
            });
        }

        // // Panggil fungsi saat halaman dimuat
        disableSelectedOptions();

        // // Panggil fungsi saat opsi dipilih atau dihapus
        $('#standard_criteria_id').on('change', function() {
            disableSelectedOptions();
            $(this).select2('close');
        });

        //Pastikan opsi nonaktif tidak dihapus saat mengirimkan formulir
        $('form').on('submit', function() {
            $('#standard_criteria_id option').removeAttr('disabled');
        });
    });
</script>
<!-- <script>
    // ketika tema dirubah, topic di isi
    $('#standard_category_id').change(function() {
                var categoryId = this.value;
                $("#standard_criteria_id").html('');
                $.ajax({
                    url: "{{ route('DOC.get_standard_criteria_id_by_id') }}",
                    type: "GET",
                    data: {
                        id: categoryId,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#standard_criteria_id').html('<option value="">Select Topic</option>');
                        $.each(result, function(key, value) {
                            $("#standard_criteria_id").append('<option value="' + value.id +
                                '">' + value.title + '</option>');
                        });
                    }
                });
            });
    </script>
</script> -->
@endsection
