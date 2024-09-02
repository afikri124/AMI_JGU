@extends('layouts.master')
@section('title', 'Auditing Assesment')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
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
    @if (session('msg'))
            <div class="alert alert-success">
                {{ session('msg') }}
            </div>
        @endif
<div class="card mb-5">
    <div class="card-body">
        <form method="POST" action="{{ route('my_audit.show', $data->id) }}" enctype="multipart/form-data">
            @csrf
            <center>
                <h3 style="color: black; font-family: Arial, Helvetica, sans-serif">FORM AUDITING ASSESSMENT</h3>
            </center>
            <hr style="color:black">
            
            @foreach ($standardCriterias as $criteria)
                <h6 class="mb-3" style="color: black"><b>{{ $loop->iteration }}. {{ $criteria->title }}</b></h6>
            
                @foreach ($criteria->statements as $no => $statement)
                    @foreach ($statement->indicators as $indicator)
                        @foreach ($observations as $observation)
                            @php
                                $filteredObs = $obs_c->where('observation_id', $observation->id)
                                                    ->where('indicator_id', $indicator->id);
                            @endphp
                            @foreach ($filteredObs as $index => $obsChecklist)
                            <input type="hidden" name="indicator_id[{{ $index }}]" value="{{ $indicator->id }}">
                            <table class="table table-bordered">
                                <tr>
                                    <th><b>Standard Statement</b></th>
                                </tr>
                                <tr>
                                    <td style="width: 60%">
                                        <ul class="text-primary">{{ $loop->parent->iteration }}. {{ $statement->name }}</ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 60%">
                                        <strong>Indicator</strong>
                                        <ul>{!! $indicator->name !!}</ul>
                                    </td>
                                    <td style="width: 35%">
                                        <div id="data-sets">
                                            <div id="data-set">
                                                <div class="checkbox-group">
                                                    <input type="radio" id="ks_{{ $index }}" name="obs_checklist_option[{{ $index }}]" value="KS" {{ $obsChecklist->obs_checklist_option == 'KS' ? 'checked' : '' }} disabled/>
                                                    <label for="ks_{{ $index }}">KS</label>
                                                </div>
                                                <div class="checkbox-group">
                                                    <input type="radio" id="obs_{{ $index }}" name="obs_checklist_option[{{ $index }}]" value="OBS" {{ $obsChecklist->obs_checklist_option == 'OBS' ? 'checked' : '' }} disabled/>
                                                    <label for="obs_{{ $index }}">OBS</label>
                                                </div>
                                                <div class="checkbox-group">
                                                    <input type="radio" id="kts_minor_{{ $index }}" name="obs_checklist_option[{{ $index }}]" value="KTS MINOR" {{ $obsChecklist->obs_checklist_option == 'KTS MINOR' ? 'checked' : '' }} disabled/>
                                                    <label for="kts_minor_{{ $index }}">KTS MINOR</label>
                                                </div>
                                                <div class="checkbox-group">
                                                    <input type="radio" id="kts_mayor_{{ $index }}" name="obs_checklist_option[{{ $index }}]" value="KTS MAYOR" {{ $obsChecklist->obs_checklist_option == 'KTS MAYOR' ? 'checked' : '' }} disabled/>
                                                    <label for="kts_mayor_{{ $index }}">KTS MAYOR</label>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 60%" id="review-docs">
                                        <strong>List Document</strong>
                                        @foreach ($statement->reviewDocs as $reviewDoc)
                                            <ul>{!! $reviewDoc->name !!}</ul>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($obsChecklist->doc_path)
                                            @php
                                                $fileName = basename($obsChecklist->doc_path);
                                                $fileNameWithoutId = preg_replace('/^\d+_/', '', $fileName);
                                            @endphp
                                            <strong class="form-label">File: </strong>
                                            <a href="{{ asset($obsChecklist->doc_path) }}" target="_blank" style="word-wrap: break-word; display: inline-block; max-width: 450px;">
                                                {{ $fileNameWithoutId }}
                                            </a>
                                        @endif
                                        @error('doc_path')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <br>
                                        @if ($obsChecklist->link)
                                            <strong class="form-label">Link: </strong>
                                            <a href="{{ asset($obsChecklist->link) }}" target="_blank" style="word-wrap: break-word; display: inline-block; max-width: 450px;">
                                                {{ $obsChecklist->link }}
                                            </a>
                                        @endif
                                        @error('link')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label for="remark_description_{{ $index }}" class="form-label">
                                            <b>Deskripsi Audit:</b><i class="text-danger">*</i>
                                        </label>
                                        <div class="input-group input-group-merge has-validation">
                                        <textarea id="remark_description_{{ $index }}" name="remark_description[{{ $index }}]"
                                        class="form-control" maxlength="250" placeholder="MAX 250 characters..." disabled>{{ $obsChecklist->remark_description ?? '' }}</textarea>
                                        @error('remark_description.' . $index)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label for="remark_success_failed_{{ $index }}" class="form-label">
                                            <b>Faktor Pendukung Keberhasilan/Kegagalan:</b><i class="text-danger">*</i>
                                        </label>
                                        <div class="input-group input-group-merge has-validation">
                                        <textarea id="remark_success_failed_{{ $index }}" name="remark_success_failed[{{ $index }}]"
                                        class="form-control" maxlength="250" placeholder="MAX 250 characters..." disabled>{{ $obsChecklist->remark_success_failed ?? '' }}</textarea>
                                        @error('remark_success_failed.' . $index)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label for="remark_recommend_{{ $index }}" class="form-label">
                                            <b>Rekomendasi Audit:</b><i class="text-danger">*</i>
                                        </label>
                                        <div class="input-group input-group-merge has-validation">
                                        <textarea id="remark_recommend_{{ $index }}" name="remark_recommend[{{ $index }}]"
                                        class="form-control" maxlength="250" placeholder="MAX 250 characters..." disabled>{{ $obsChecklist->remark_recommend ?? '' }}</textarea>
                                        @error('remark_recommend.' . $index)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label for="remark_upgrade_repair_{{ $index }}" class="form-label">
                                            <b>Rencana Peningkatan/Perbaikan:</b><i class="text-danger">*</i>
                                        </label>
                                        <textarea type="text" id="remark_upgrade_repair_{{ $index }}" class="form-control"
                                            name="remark_upgrade_repair[{{ $index }}]" maxlength="250"
                                            placeholder="MAX 250 characters...">{{ $obsChecklist->remark_upgrade_repair ?? '' }}</textarea>
                                        @error('remark_upgrade_repair.' . $index)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label for="person_in_charge_{{ $index }}" class="form-label">
                                            <b>Person In Charge</b><i class="text-danger">*</i>
                                        </label>
                                        <input type="text" id="person_in_charge_{{ $index }}" class="form-control" name="person_in_charge[{{ $index }}]"
                                        placeholder="example: BPUK" value="{{ $obsChecklist->person_in_charge }}">
                                        @error('person_in_charge.' . $index)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label for="plan_completed_{{ $index }}" class="form-label">
                                            <b>Plan Complete</b><i class="text-danger">*</i>
                                        </label>
                                        <input type="date" class="form-control" name="plan_completed[{{ $index }}]" id="plan_completed_{{ $index }}"
                                        placeholder="YYYY-MM-DD" value="{{ $obsChecklist->plan_completed }}">
                                        @error('plan_completed.' . $index)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </td>
                                </tr>
                            </table>
                            @endforeach
                        @endforeach
                        <hr>
                    @endforeach
                @endforeach
            @endforeach
            <div class="row">
                <div class="col-lg-12 col-md-6 mb-3">
                    <label for="date_prepared" class="form-label"><b>Date Prepared</b><i class="text-danger">*</i></label>
                    <input type="date" class="form-control" name="date_prepared" id="date_prepared" value="{{ $observation->date_prepared }}">
                    @error('date_prepared')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>  
            </div>
            <div class="row">
                <div class="card-footer d-flex justify-content-between align-items-end">
                    <div class="d-flex">
                        <button class="btn me-1" style="background-color: #06D001; color: white;" type="submit" name="action" value="Save">Save Draft</button>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-primary me-2" type="submit" name="action" value="Submit">Submit</button>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary me-1">Back</a>
                    </div>
                </div>
            </div>
        </form>                
  </div>
  </div>
@endsection

@section('script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
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