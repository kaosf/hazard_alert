@extends('layouts.app')

@section('title', '店舗・イベントQRコード生成')

@section('content')

    <h2 class="h3 mb-4">店舗・イベント・施設QRコード生成</h2>

    <p class="mb-5">
        こちらは「{{ config('app.name') }}」店舗関係者・イベント主催者様用のご登録ページです。<br>
        下記入力欄に皆様の店舗・イベント・集客施設の情報のご登録をお願いします。<br>
        「登録してQRコードを生成」のボタンを押すと、掲示用のQRコードをダウンロードすることができます。<br>
        また、登録いただいた情報はメール受信を希望するユーザーに公開されます。
    </p>

    <form method="POST" action="">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="group[name]">店舗（支店）・イベント・施設名 <span class="badge badge-danger">必須</span></label>
                    <input id="group[name]" name="group[name]" type="text" value="{{ old('group.name') }}" class="@error('group.name') is-invalid @enderror form-control">
                    @error('group.name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="group[category]">業種 <span class="badge badge-danger">必須</span></label>
                    <select id="group[category]" name="group[category]" class="form-control">
                        <option value="">--選択して下さい--</option>
                        <option value="県有施設"                   @if(old('group.category') == "県有施設"                  ) selected @endif>県有施設</option>
                        <option value="市町村施設"                 @if(old('group.category') == "市町村施設"                ) selected @endif>市町村施設</option>
                        <option value="飲食店"                     @if(old('group.category') == "飲食店"                    ) selected @endif>飲食店</option>
                        <option value="劇場・映画館・ライブハウス" @if(old('group.category') == "劇場・映画館・ライブハウス") selected @endif>劇場・映画館・ライブハウス</option>
                        <option value="パチンコ店・ゲームセンター" @if(old('group.category') == "パチンコ店・ゲームセンター") selected @endif>パチンコ店・ゲームセンター</option>
                        <option value="カラオケ店"                 @if(old('group.category') == "カラオケ店"                ) selected @endif>カラオケ店</option>
                        <option value="ホテル・旅館・宿泊施設"     @if(old('group.category') == "ホテル・旅館・宿泊施設"    ) selected @endif>ホテル・旅館・宿泊施設</option>
                        <option value="百貨店・スーパー・小売業"   @if(old('group.category') == "百貨店・スーパー・小売業"  ) selected @endif>百貨店・スーパー・小売業</option>
                        <option value="理容室・美容室"             @if(old('group.category') == "理容室・美容室"            ) selected @endif>理容室・美容室</option>
                        <option value="医療機関"                   @if(old('group.category') == "医療機関"                  ) selected @endif>医療機関</option>
                        <option value="スポーツ施設"               @if(old('group.category') == "スポーツ施設"              ) selected @endif>スポーツ施設</option>
                        <option value="集会場・展示施設"           @if(old('group.category') == "集会場・展示施設"          ) selected @endif>集会場・展示施設</option>
                        <option value="その他"                     @if(old('group.category') == "その他"                    ) selected @endif>その他</option>
                    </select>
                    @error('group.category')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="group[owner]">担当者氏名 <span class="badge badge-danger">必須</span></label>
                    <input id="group[owner]" name="group[owner]" type="text" value="{{ old('group.owner') }}" class="@error('group.owner') is-invalid @enderror form-control">
                    @error('group.owner')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="group[telephone]">連絡先電話番号 <span class="badge badge-danger">必須</span></label>
                    <input id="group[telephone]" name="group[telephone]" type="text" value="{{ old('group.telephone') }}" class="@error('group.telephone') is-invalid @enderror form-control">
                    @error('group.telephone')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">記号無し、数字のみで入力してください。</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="group[email]">担当者メールアドレス <span class="badge badge-danger">必須</span></label>
                    <input id="group[email]" name="group[email]" type="text" value="{{ old('group.email') }}" class="@error('group.email') is-invalid @enderror form-control">
                    @error('group.email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="group[zip_code]">郵便番号 <span class="badge badge-danger">必須</span></label>
                    <input id="group[zip_code]" name="group[zip_code]" type="text" value="{{ old('group.zip_code') }}" class="@error('group.zip_code') is-invalid @enderror form-control">
                    @error('group.zip_code')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">記号無し、数字のみで入力してください。</small>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="group[address]">住所 <span class="badge badge-danger">必須</span></label>
                    <input id="group[address]" name="group[address]" type="text" value="{{ old('group.address') }}" class="@error('group.address') is-invalid @enderror form-control">
                    @error('group.address')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-8 radio-inline">
                <label class="mr-4">
                    <input type="radio" name="group[has_period]" value="false" onClick="changePeriodRowVisibility();" @if(old('group.has_period')==='false' || empty(old('group.has_period'))) checked @endif/>
                    開催期間無し
                </label>
                <label>
                    <input type="radio" name="group[has_period]" value="true" onClick="changePeriodRowVisibility();" @if(old('group.has_period')==='true') checked @endif/>
                    開催期間有り
                </label>
            </div>
        </div>

        <div id="period_row" class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="group[start_at]">開始日時</label>
                    <input id="group[start_at]" name="group[start_at]" type="text" value="{{ old('group.start_at') }}" class="@error('group.start_at') is-invalid @enderror form-control">
                    @error('group.start_at')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">イベントなどの開始日時が決まっている場合はご記入ください。</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="group[end_at]">終了日時</label>
                    <input id="group[end_at]" name="group[end_at]" type="text" value="{{ old('group.end_at') }}" class="@error('group.end_at') is-invalid @enderror form-control">
                    @error('group.end_at')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">イベントなどの終了日時が決まっている場合はご記入ください。</small>
                </div>
            </div>
        </div>

        <hr class="mt-5 mb-5">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <p style="text-align: center">
                    <label>
                        <input type="checkbox" id="group[agreed]" name="group[agreed]" value="true" onClick="syncSubmitButtonEnabled();" @if(old('group.agreed')) checked @endif/>
                        <a href="/terms_organization" target="__blank">利用規約</a>に同意する
                    </label>
                </p>
                @error('group.agreed')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <button id="submit_button" class="btn btn-primary btn-lg btn-block" type="submit">登録してQRコードを生成</button>
            </div>
        </div>

    </form>
@endsection


@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.min.css">

    <script type="text/javascript">
        // 送信ボタン制御。
        function syncSubmitButtonEnabled() {
            document.getElementById('submit_button').disabled = !document.getElementById('group[agreed]').checked;
        }

        function changePeriodRowVisibility() {
            has_period = $("input[name='group[has_period]']:checked").val();
            if (has_period === 'false') {
                $("#period_row").hide();
            }
            if (has_period === 'true') {
                $("#period_row").show();
            }
        }

        $(function () {
            jQuery.datetimepicker.setLocale('ja');
            $("[name='group[start_at]']").datetimepicker({
                step: 10,
                format: 'Y-m-d H:i:00'
            });

            jQuery.datetimepicker.setLocale('ja');
            $("[name='group[end_at]']").datetimepicker({
                step: 10,
                format: 'Y-m-d H:i:00'
            });

            syncSubmitButtonEnabled();
            changePeriodRowVisibility();
        });
    </script>

@endsection
