@extends('layouts.frontend')
@section('subtitle', trans('global.show').' '.trans('cruds.faqQuestion.title'))
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <a class="btn btn-default" href="{{ route('frontend.faq-questions.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.faqQuestion.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $faqQuestion->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.faqQuestion.fields.category') }}
                                    </th>
                                    <td>
                                        {{ $faqQuestion->category->category ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.faqQuestion.fields.question') }}
                                    </th>
                                    <td>
                                        {{ $faqQuestion->question }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.faqQuestion.fields.answer') }}
                                    </th>
                                    <td>
                                        {{ $faqQuestion->answer }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection