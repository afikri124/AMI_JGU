@extends('layouts.master')
@section('title', 'Remark Auditor | Make Report')

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
<div class="card mb-5">
    <div class="card-body">
    <form method="POST" action="{{ route('observations.update_remark', $data->id) }}"
    enctype="multipart/form-data">
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
                @foreach ($obs_c as $obsChecklist)
                    @if ($obsChecklist->observation_id == $observation->id)
        <table class="table table-bordered">
            <tr>
                <th><b>Standard Statement</b></th>
                <td>
                    <a href="{{ $data->link }}" target="_blank">{{ $data->link }}</a>
                    @error('link')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </td>
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
                <td style="width: 60%" id="review-docs">
                    <strong>Review Document</strong>
                    @foreach ($statement->reviewDocs as $reviewDoc)
                        <ul>{!! $reviewDoc->name !!}</ul>
                    @endforeach
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
                    <label for="remark_upgrade_repair" class="form-label"><b>Rencana Peningkatan/Perbaikan:</b><i class="text-danger">*</i></label>
                    <textarea type="text" id="remark_upgrade_repair" class="form-control bg-user"
                        name="remark_upgrade_repair_{{ $observation->id }}" maxlength="250"
                        placeholder="MAX 250 characters..." readonly>{{ $obsChecklist->remark_upgrade_repair ?? '' }}</textarea>
                        @error('remark_upgrade_repair')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </td>
            </tr>
                @break
            @endif
        @endforeach
    @endforeach
</table>
    @endforeach
        @endforeach
            @endforeach
            <hr class="text-dark">
            <div class="row">
                <div class="col-lg-6 col-md-6 mb-3">
                    <label for="person_in_charge" class="form-label"><b>Pihak yang Bertanggung Jawab</b><i class="text-danger">*</i></label>
                    <input type="text" id="person_in_charge" class="form-control bg-user" name="person_in_charge" value="{{$observation->person_in_charge}}"
                            placeholder="Pihak Bertanggung Jawab..." readonly>
                            @error('person_in_charge')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                </div>
                <div class="col-lg-6 col-md-6 mb-3">
                    <label for="plan_complated" class="form-label"><b>Jadwal Penyelesaian</b><i class="text-danger">*</i></label>
                    <input type="date" class="form-control bg-user" name="plan_complated" id="plan_complated" value="{{$observation->plan_complated}}"
                            placeholder="YYYY-MM-DD" readonly>
                            @error('plan_complated')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                </div>
            </div>
            <div>
                <label class="form-label" for="basicDate"><b>Remark</b><i class="text-danger">*</i></label></label>
                <div class="input-group input-group-merge has-validation">
                    <textarea type="text" class="form-control @error('remark_plan') is-invalid @enderror"
                    name="remark_plan" placeholder="MAX 250 characters..." value="{{$observation->remark_plan}}"></textarea>
                    @error('remark_plan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
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

    // $(document).ready(function() {

    //             $("#remark_description").prop('disabled', true).attr('data-placeholder',
    //                 'Remark Descripstion data is required');
    //             $("#obs_checklist_option").prop('disabled', true).attr('data-placeholder',
    //                 'Form Checklist data is required');
    //             $("#remark_success_failed").prop('disabled', true).attr('data-placeholder',
    //                 'Remark success failed data is required');
    //             $("#remark_recommend").prop('disabled', true).attr('data-placeholder',
    //                 'Remark Recommend data is required');
    //             $("#remark_upgrade_repair").prop('disabled', true).attr('data-placeholder',
    //                 'Remark Upgrade Repair data is required');
    //             $("#person_in_charge").prop('disabled', true).attr('data-placeholder',
    //                 'Person In Charge data is required');
    //             $("#plan_completed").prop('disabled', true).attr('data-placeholder',
    //                 'Plan Complated data is required');
    //         });
</script>
<!-- <script>
    const wizardIcons = document.querySelector('.wizard-icons-example');

    if (typeof wizardIcons !== undefined && wizardIcons !== null) {
        const wizardIconsBtnNextList = [].slice.call(wizardIcons.querySelectorAll('.btn-next')),
              wizardIconsBtnPrevList = [].slice.call(wizardIcons.querySelectorAll('.btn-prev')),
              wizardIconsBtnSubmit = wizardIcons.querySelector('.btn-submit');

        const iconsStepper = new Stepper(wizardIcons, {
            linear: false
        });

        if (wizardIconsBtnNextList) {
            wizardIconsBtnNextList.forEach(wizardIconsBtnNext => {
                wizardIconsBtnNext.addEventListener('click', event => {
                    iconsStepper.next();
                });
            });
        }

        if (wizardIconsBtnPrevList) {
            wizardIconsBtnPrevList.forEach(wizardIconsBtnPrev => {
                wizardIconsBtnPrev.addEventListener('click', event => {
                    iconsStepper.previous();
                });
            });
        }
    }
    </script> -->
@endsection
