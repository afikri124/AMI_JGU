@extends('layouts.master')
@section('title', 'RTM Auditee')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<!-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}"> -->
@endsection

@section('style')
<style>
    .input-validation-error~.select2 .select2-selection {
        border: 1px solid red;
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
        .text-wrapper {
        width: 200px; /* set a width for the wrapping container */
        word-wrap: break-word /* ensures the text wraps to the next line if it overflows the container */
    }
    .bg-user {
        background-color: #F5F7F8;
    }
    .hidden {
        display: none;
    }

</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
    @if(session('msg'))
        <div class="alert alert-primary alert-dismissible" role="alert">
            {{ session('msg') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger outline alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
            data-bs-original-title="" title=""></button>
    </div>
@endif
<div class="card mb-5">
    <div class="card-body">
    <form action="{{ route('my_audit.edit_rtm', $data->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Account Details -->
      <strong class="text-primary">Category Standard</strong>
        @foreach ($standardCategories as $category)
            <h6 class="mb-0" name="standard_category_id" id="standard_category_id">
                {{ $category->description }}
            </h6>
        @endforeach
        <p></p>

        <strong class="text-primary">Criteria Standard</strong>
        @foreach ($standardCriterias as $criteria)
            <h6 class="mb-0" name="standard_criteria_id" id="standard_criteria_id">
                {{ $criteria->title }}
            </h6>
        @endforeach
        <p></p>
    @foreach ($standardCriterias as $criteria)
        <h6 class="text-primary"><b>{{ $loop->iteration }}. {{ $criteria->title }}</b></h6>

        @foreach ($criteria->statements as $no => $statement)
        @foreach ($statement->indicators as $indicator)
        @foreach ($observations as $observation)
            @php
                $filteredObs = $obs_c->where('observation_id', $observation->id)
                                        ->where('indicator_id', $indicator->id);
            @endphp
            @foreach ($filteredObs as $obsChecklist)
        <table class="table table-bordered">
            <tr>
                <th><b>Standard Statement</b></th>
            </tr>
            <tr>
                <td style="width: 60%">
                    <ul class="text-primary">{{ $loop->parent->iteration }}. {{ $statement->name }}</ul>
                </td>
                <td style="width: 35%">
                    <div id="data-sets">
                        <div id="data-set">
                            <div class="checkbox-group">
                                <input type="radio" id="ks_{{ $observation->id }}" name="obs_checklist_option[{{ $indicator->id }}]" value="KS" {{ $obsChecklist->obs_checklist_option == 'KS' ? 'checked' : '' }} disabled />
                                <label for="ks_{{ $observation->id }}">KS</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="radio" id="obs_{{ $observation->id }}" name="obs_checklist_option[{{ $indicator->id }}]" value="OBS" {{ $obsChecklist->obs_checklist_option == 'OBS' ? 'checked' : '' }} disabled />
                                <label for="obs_{{ $observation->id }}">OBS</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="radio" id="kts_minor_{{ $observation->id }}" name="obs_checklist_option[{{ $indicator->id }}]" value="KTS MINOR" {{ $obsChecklist->obs_checklist_option == 'KTS MINOR' ? 'checked' : '' }} disabled />
                                <label for="kts_minor_{{ $observation->id }}">KTS MINOR</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="radio" id="kts_mayor_{{ $observation->id }}" name="obs_checklist_option[{{ $indicator->id }}]" value="KTS MAYOR" {{ $obsChecklist->obs_checklist_option == 'KTS MAYOR' ? 'checked' : '' }} disabled />
                                <label for="kts_mayor_{{ $observation->id }}">KTS MAYOR</label>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 60%">
                    <strong>Indicator</strong>
                    <ul>{!! $indicator->name !!}</ul>
                </td>
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
                </td>
            </tr>
            <tr>
                <td style="width: 60%" id="review-docs">
                    <strong>Review Document</strong>
                    @foreach ($statement->reviewDocs as $reviewDoc)
                        <ul>{!! $reviewDoc->name !!}</ul>
                    @endforeach
                </td>
                <td>
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
            </tr>
            <tr>
                <td colspan="3">
                    <label for="remark_description_{{ $observation->id }}" class="form-label">
                        <b>Deskripsi Audit:</b><i class="text-danger">*</i>
                    </label>
                    <textarea id="remark_description_{{ $observation->id }}" name="remark_description[{{ $obsChecklist->indicator_id }}]"
                    class="form-control bg-user" maxlength="250" placeholder="MAX 250 characters..." readonly>{{ $obsChecklist->remark_description ?? '' }}</textarea>
                    @error('remark_description.' . $obsChecklist->indicator_id)
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <label for="remark_success_failed_{{ $observation->id }}" class="form-label">
                        <b>Faktor Pendukung Keberhasilan/Kegagalan:</b><i class="text-danger">*</i>
                    </label>
                    <textarea id="remark_success_failed_{{ $observation->id }}" name="remark_success_failed[{{ $obsChecklist->indicator_id }}]"
                    class="form-control bg-user" maxlength="250" placeholder="MAX 250 characters..." readonly>{{ $obsChecklist->remark_success_failed ?? '' }}</textarea>
                    @error('remark_success_failed.' . $obsChecklist->indicator_id)
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <label for="remark_recommend_{{ $observation->id }}" class="form-label">
                        <b>Rekomendasi Audit:</b><i class="text-danger">*</i>
                    </label>
                    <textarea id="remark_recommend_{{ $observation->id }}" name="remark_recommend[{{ $obsChecklist->indicator_id }}]"
                    class="form-control bg-user" maxlength="250" placeholder="MAX 250 characters..." readonly>{{ $obsChecklist->remark_recommend ?? '' }}</textarea>
                    @error('remark_recommend.' . $obsChecklist->indicator_id)
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </td>
            </tr>
            <tr>
            <td colspan="3">
                <label for="remark_upgrade_repair_{{ $indicator->id }}" class="form-label"><b>Rencana Peningkatan/Perbaikan:</b><i class="text-danger">*</i></label>
                <textarea type="text" id="remark_upgrade_repair_{{ $indicator->id }}" class="form-control bg-user"
                    name="remark_upgrade_repair[{{ $indicator->id }}]" maxlength="250"
                    placeholder="MAX 250 characters..." readonly>{{ $obsChecklist->remark_upgrade_repair ?? '' }}</textarea>
                @error('remark_upgrade_repair.' . $indicator->id)
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </td>
        </tr>
</table>
@endforeach
    @endforeach
    @endforeach
    <hr class="text-dark">
    @endforeach
        @endforeach
            <!-- <tr>
                <td>
                    <div class="form-group mb-3">
                        <label for="plan_complated_end_{{ $observation->id }}" class="form-label"><b>Target Akhir</b><i class="text-danger">*</i></label>
                        <input type="date" class="form-control" name="plan_complated_end[{{ $indicator->id }}]" id="plan_complated_end_{{ $indicator->id }}"
                            value="{{ old('plan_complated_end.' . $indicator->id) }}" placeholder="YYYY-MM-DD">
                        @error('plan_complated_end.' . $indicator->id)
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </td>
            </tr> -->
            <p></p>
            <div class="text-end">
                <button class="btn btn-primary me-1" type="submit">Submit</button>
                <a href="{{ url()->previous() }}">
                    <span class="btn btn-outline-secondary">Back</span>
                </a>
            </div>
        </div>
      </div>
    </form>
  </div>
  </div>
@endsection

@section('script')
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <script type="text/javascript">
    "use strict";
    setTimeout(function () {
        (function ($) {
            "use strict";
            $(".select2").select2({
                allowClear: true,
                minimumResultsForSearch: 7,
            });
        })(jQuery);
    }, 350);
</script>
@endsection
