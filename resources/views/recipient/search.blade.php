<?php
/**
 * @var Collection|Group $groups
 * 店舗・イベント情報
 */

use App\Group;
use phpDocumentor\Reflection\Types\Collection;
?>

@extends('layouts.app')

@section('title', 'メールアドレスのダウンロード')

@section('content')
    <form action="/recipient/search" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="group">店舗・イベント名等</label>
                    <select class="form-control select2" name="search[group_id]" class="@error('search.group_id') is-invalid @enderror form-control">
                        <option></option>
                    </select>
                    @error('search.group_id')
                    <div class="alert alert-danger">店舗名・イベント名・会場名 または 業種のどちらかは必ず指定してください。</div>
                    @enderror
                </div>
                <div id="group_info" style="display: none">
                    <p id="address"></p>
                    <p id="telephone"></p>
                    <p id="owner"></p>
                    <p id="email"></p>
                </div>
            </div>
        </div>

        <hr class="mt-2">

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="category">業種</label>
                    <select class="form-control" name="search[category]" class="@error('search.category') is-invalid @enderror form-control">
                        <option value=""></option>
                        @foreach (App\Group::CATEGORIES as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                    @error('search.category')
                    <div class="alert alert-danger">店舗名・イベント名・会場名 または 業種のどちらかは必ず指定してください。</div>
                    @enderror
                </div>
                <div id="group_info" style="display: none">
                    <p id="address"></p>
                    <p id="telephone"></p>
                    <p id="category"></p>
                </div>
            </div>
        </div>

        <hr class="mt-2">

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="start_at">登録日時の範囲（開始）</label>
                    <input id="start_at" name="search[start_at]" type="text" value="{{ old('search.start_at') }}" class="@error('search.start_at') is-invalid @enderror form-control">
                    @error('search.start_at')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="end_at">登録日時の範囲（終了）</label>
                    <input id="end_at" name="search[end_at]" type="text" value="{{ old('search.end_at') }}" class="@error('search.end_at') is-invalid @enderror form-control">
                    @error('search.end_at')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <p>
                        <small class="text-muted">登録日時の範囲を指定しなかった場合、対象のメールアドレスが全件出力されます</small><br>
                        <small class="text-muted">登録日時の範囲を指定する場合、開始・終了のどちらも入力する必要があります</small>
                    </p>
                </div>
            </div>
        </div>

        <hr class="mt-5 mb-5">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <button class="btn btn-primary btn-lg btn-block" type="submit">検索</button>
            </div>
        </div>
    </form>

    @if(isset($recipients_count))
        <hr class="mt-5 mb-5">
        <h3 class="h3 mb-3">検索結果：{{$recipients_count}}件</h3>
        <p>店舗・イベント名等　　：{{$searched['group_name']}}</p>
        <p>登録日時の範囲（開始）：{{$searched['start_at']}}</p>
        <p>登録日時の範囲（終了）：{{$searched['end_at']}}</p>
        @if($recipients_count != 0)
            <form action="/recipient/download" method="post">
                @csrf
                <input type="hidden" name="download[group_id]" value="{{$searched['group_id']}}">
                <input type="hidden" name="download[start_at]" value="{{$searched['start_at']}}">
                <input type="hidden" name="download[end_at]" value="{{$searched['end_at']}}">
                <hr class="mt-5 mb-5">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">検索結果をダウンロード</button>
                    </div>
                </div>
                <p style="text-align: center"><small class="text-muted">ダウンロードしたcsvファイルが開けない場合、ファイル名を変更すると開ける場合があります</small></p>
            </form>
        @endif

    @endif
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link href="//cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />
    <script src="//cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.min.css">

    <script type="text/javascript">
        $(function(){
            $('.select2').select2({
                theme: 'bootstrap',
                placeholder: 'リストから選択してください',
                ajax: {
                    url: "/group/select2_search",
                    dataType: 'json',
                    delay: 250,
                    data: (params) => {
                        return {
                            q: params.term,
                        }
                    },
                    processResults: (data, params) => {
                        const results = data.groups.map(group => {
                            return {
                                id: group.id,
                                text: group.name,
                            };
                        });
                        return {
                            results: results,
                        }
                    },
                    cache: true,
                    minimumInputLength: 1,
                },
            });
        });
    </script>

    <script type="text/javascript">
        $(function()
        {
            jQuery.datetimepicker.setLocale('ja');
            $("[name='search[start_at]']").datetimepicker({
                step:10,
                format:'Y-m-d H:i:00'
            });
        });
    </script>

    <script type="text/javascript">
        $(function()
        {
            jQuery.datetimepicker.setLocale('ja');
            $("[name='search[end_at]']").datetimepicker({
                step:10,
                format:'Y-m-d H:i:00'
            });
        });

        $(function() {
            $('select').change(function() {
                let group_id = $("option:selected", this).val();
                $.ajax({
                    url:'/group/select2_search?group_id=' + group_id,
                    type:'GET',
                    dataType: 'json'
                }).then(
                    function (json) {
                        let groups_len = Object.keys(json.groups).length;
                        if(groups_len !== 0){
                            let groups = json.groups;
                            for(let i = 0; i < groups_len; i++){
                                $('p#address').text("住所　　：" + groups[i].address);
                                $('p#telephone').text("電話番号：" + groups[i].telephone);
                                $('p#owner').text("担当者：" + groups[i].owner);
                                $('p#email').text("メールアドレス：" + groups[i].email);
                                $('#group_info').show();
                            }
                        }
                    }
                );
            });
        });
    </script>
@endsection
