@extends('layouts.master')
@section('title', 'Upload RTM Auditee')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('style')
<style>
    .input-validation-error~.select2 .select2-selection {
        border: px solid red;
    }
    .form-container {
        width: 600px;
        margin: 50px auto;
        border: 1px solid #ccc;
        padding: 20px;
        box-shadow: 2px 2px 8px #aaa;
        border-radius: 5px;
      }
      table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
      }
      table,
      th,
      td {
        border: 1px solid #ddd;
      }
      th,
      td {
        padding: 10px;
        text-align: left;
      }
      .checkbox-group {
        display: flex;
        align-items: center;
      }
      .checkbox-group input {
        margin-right: 5px;
      }
      .comment {
        width: 100%;
        height: 50px;
        padding: 10px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
      }
      table.dataTable tbody td {
        vertical-align: middle;
        }

        table.dataTable td:nth-child(2) {
            max-width: 120px;
        }

        table.dataTable td:nth-child(3) {
            max-width: 100px;
        }
      table.dataTable td {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<div class="card p-3">
    <div class="card-datatable table-responsive">
        <div class="card-header flex-column flaex-md-row pb-0">
            <div class="row">
                <div class="col-12 pt-3 pt-md-0">
                    <div class="col-12">
                        <div class="offset-md-0 col-md-0 text-md-end text-center pt-3 pt-md-0">
    <form action="{{ route('my_audit.edit_rtm', $data->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <h5><b><center>RAPAT TINJAUAN MANAJEMEN PRODI {{ $data->departments->name }} TAHUN {{ $data->periode }}</center></b></h5>
    <p></p>
  <table width="100%">
    <tr>
        <th><center>No</center></th>
        <th><center>Standar Mutu </center></th>
        <th><center>Deskripsi Permasalahan</center></th>
        <th><center>Akar Penyebab</center></th>
        <th><center>Tindakan Koreksi/ <br>Tindakan Perbaikan <br>dan Peningkatan</center></th>
        <th><center>Upload Doc/Link <br>& Komentar</center></th>
    </tr>
    <tr>
    @php $counter = 1; @endphp
@foreach ($standardCriterias as $criteria)
    @php $isFirstRow = true; @endphp
    @foreach ($criteria->indicators as $indicator)
        @foreach ($observations as $observation)
            @php
                $filteredObs = $obs_c->where('observation_id', $observation->id)
                                        ->where('indicator_id', $indicator->id);
            @endphp
            @foreach ($filteredObs as $obsChecklist)
                <tr>
                    @if ($isFirstRow)
                        <td><center>{{ $counter }}.</center></td>
                        <td style="width: 17%"><b>{{ $criteria->title }}</b></td>
                        @php $isFirstRow = false; @endphp
                    @else
                        <td></td>
                        <td></td>
                    @endif
                    <td style="width: 17%">{{ $obsChecklist->remark_description }}</td>
                    <td style="width: 17%">{{ $obsChecklist->remark_success_failed }}</td>
                    <td style="width: 17%">{{ $obsChecklist->remark_upgrade_repair }}</td>
                    <td>
                        <form method="POST" action="{{ route('my_audit.edit_rtm', $data->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="doc_path_rtm" class="form-label large-text"><b>Upload Document | </b><i style="color: black;">MAX. 50mb</i></label>
                                <input type="file" class="form-control @error('doc_path_rtm') is-invalid @enderror" name="doc_path_rtm" accept=".png,.jpg,.jpeg,.pdf,.xls,.xlsx">
                                <input type="hidden" name="indicator_id" value="{{ $indicator->id }}">
                                @error('doc_path_rtm')
                                    <div class="text-danger-custom">Please upload a valid document. The file size should not exceed 50MB.</div>
                                @enderror
            
                                @if ($obsChecklist && $obsChecklist->doc_path_rtm)
                                    @php
                                        $fileName = basename($obsChecklist->doc_path_rtm);
                                        $fileNameWithoutId = preg_replace('/^\d+_/', '', $fileName);
                                    @endphp
                                    <strong class="form-label">File: </strong>
                                    <a href="{{ asset($obsChecklist->doc_path_rtm) }}" target="_blank" style="word-wrap: break-word; display: inline-block; max-width: 500px;">
                                        {{ $fileNameWithoutId }}
                                    </a>
                                        <button formaction="{{ route('my_audit.delete_file_rtm', ['id' => $obsChecklist->id]) }}"
                                                class="btn btn-danger btn-sm" type="submit"
                                                onclick="return confirm('Are you sure you want to delete this file?');">
                                            Delete File
                                        </button>
                                    </div>
                                @endif
                                <button class="btn btn-success btn-sm mt-2" type="submit" name="save_file">Save</button>
                            </div>
                        </form>
            
                        <!-- Form untuk Link Document -->
                        <form method="POST" action="{{ route('my_audit.edit_rtm', $data->id) }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="link_rtm" class="form-label large-text"><b>Link Document</b></label>
                                <input type="text" class="form-control @error('link_rtm') is-invalid @enderror" name="link_rtm" placeholder="Link Drive/Document Audit" value="{{ $obsChecklist->link_rtm ?? '' }}">
                                <input type="hidden" name="indicator_id" value="{{ $indicator->id }}">
                                @error('link_rtm')
                                    <div class="text-danger-custom">Please provide a valid document link_rtm.</div>
                                @enderror
            
                                @if ($obsChecklist && $obsChecklist->link_rtm)
                                    <strong class="form-label">Link: </strong>
                                    <a href="{{ asset($obsChecklist->link_rtm) }}" target="_blank" style="word-wrap: break-word; display: inline-block; max-width: 500px;">
                                        {{ $obsChecklist->link_rtm }}
                                    </a>
                                        <button formaction="{{ route('my_audit.delete_link_rtm', ['id' => $obsChecklist->id]) }}"
                                                class="btn btn-danger btn-sm" type="submit"
                                                onclick="return confirm('Are you sure you want to delete this link?');">
                                            Delete Link
                                        </button>
                                    </div>
                                @endif
                                <button class="btn btn-success btn-sm mt-2" type="submit" name="save_link">Save</button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('my_audit.edit_rtm', $data->id) }}">
                            @csrf
                            <div>
                                <label class="form-label" for="remark_rtm_auditee"><b>Remark Document RTM</b><i class="text-danger">*</i></label>
                                <div class="input-group input-group-merge has-validation">
                                    <textarea type="text" class="form-control @error('remark_rtm_auditee') is-invalid @enderror"
                                    name="remark_rtm_auditee" placeholder="MAX 250 characters...">{{ $checklist->remark_rtm_auditee ?? '' }}</textarea>
                                    @error('remark_rtm_auditee')
                                        <div class="text-danger-custom">Please provide a remark. Maximum 250 characters allowed.</div>
                                    @enderror
                                </div>
                                <input type="hidden" name="indicator_id" value="{{ $indicator->id }}">
                                <button class="btn btn-success btn-sm mt-2" type="submit" name="save_remark">Save</button>
                            </div>
                        </form>
                    </td>
            @endforeach
            @php
                $filteredRtm = $rtm->where('observation_id', $observation->id)
                                    ->where('indicator_id', $indicator->id);
            @endphp
        @endforeach
    @endforeach
    @php
        $counter++;
        $isFirstRow = true;
    @endphp
@endforeach
</table>
        </div>
    </div>
</div>
</div>
</div>
</div>
    @endsection

@section('script')
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
@endsection
