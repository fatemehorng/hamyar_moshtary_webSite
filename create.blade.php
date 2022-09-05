@extends('admin.main')

@php($title = 'ایجاد محصول جدید')


@section('main')
    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-47">
            <div class="panel panel-default animated fadeInUp go">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">{{$title}}</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                        <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="alert alert-danger alert-dismissible err" style="display: none" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <ul class="err-body">
                        </ul>
                    </div>
                    <form id="form-st" class="form-horizontal">

                        <div class="row">
                            <div class="col-xs-4">
                                <label for="title">نام محصول</label>
                                <input value="{{old('title')}}" id="title" name="title" type="text" class="form-control"
                                       placeholder="نام محصول   . . .">
                            </div>
                            <div class="col-xs-4">
                                <label for="video_link">لینک ویدیو</label>
                                <textarea id="video_link" name="video_link" type="text" class="form-control"
                                ></textarea>
                            </div>
                        </div>
                        <div class="line-dashed"></div>
                        <div class="lg-row">
                            <div class="col-sm-3">
                                <label>دسته بندی </label>
                                <select required name="category_id" id="category_id"
                                        class="form-control select2 select2-hidden-accessible"
                                        style="width: 100%;"
                                        tabindex="-1" aria-hidden="true">
                                    <option>انتخاب کنید . . .</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->title}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>نام ست</label>
                                <select name="set_id" id="set_id"
                                        class="form-control select2 select2-hidden-accessible"
                                        style="width: 100%;"
                                        tabindex="-1" aria-hidden="true">
                                    <option value=" ">انتخاب کنید . . .</option>
                                    @foreach($sets as $set)
                                        <option value="{{$set->id}}">{{$set->title}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>فصل </label>
                                <select  name="season" id="season"
                                        class="form-control select2 select2-hidden-accessible discount-select"
                                        style="width: 100%;"
                                        tabindex="-1" aria-hidden="true">
                                        <option value="">انتخاب کنید...</option>

                                    @foreach(seasons() as $season)
                                        <option value="{{$season}}">
                                            {{__('messages.'. $season)}}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="line-dashed"></div>
                        <div class="table-responsive" id="selectjs" style="margin-bottom: 5px" hidden="true">
                            @include('admin.products.featureSelected')
                        </div>

                        <div class="col-sm-3" hidden="true" id="addFeature">
                            <button type="button" id="addFeatureField">+</button>
                            <button type="button" id="removeFeatureField">-</button>
                        </div>

                        <br/>
                        <div class="line-dashed"></div>
                        <div id="addFields" style="margin-bottom: 5px">
                            <div class="lg-row">
                                <div class="col-sm-3">
                                    <label for="size">سایز</label>
                                    <input value='{{old('size')}}' id='size[]' name='size[]'
                                           type="text"
                                           class="form-control" placeholder="سایز. . .">
                                </div>

                                <div class="col-sm-3">
                                    <label for="color">رنگ</label>
                                    <input value=' ' id='color[]' name='color[]'
                                           type="color"
                                           class="form-control" placeholder="رنگ. . .">
                                </div>

                                <div class="col-sm-3">
                                    <label for="count">تعداد</label>
                                    <input value='{{old('count')}}' id='count[]' name='count[]'
                                           type="number" min="1"
                                           class="form-control" placeholder="تعدا. . .">
                                </div>
                                <div class="col-sm-3">
                                    <label for="price">قیمت</label>
                                    <input value='{{old('price')}}' id='price[]' name='price[]'
                                           type="text"
                                           class="form-control" placeholder="قیمت. . .">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" id="addFieldsButton">+</button>
                            <button type="button" id="removeFieldsBotton">-</button>
                        </div>
                        <br/>
                        <div class="line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-12" id="editor">
                                <label for="short_description">توضیح کوتاه</label>
                                <textarea id="editor" name="short_description" type="text" class="form-control"
                                          placeholder="توضیح کوتاه   . . .">{{old('short_description')}}</textarea>
                            </div>
                        </div>
                        <div class="line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <label for="long_description">توضیح کامل</label>
                                <textarea id="long_description" name="long_description" type="text"
                                          class="form-control my-editor"
                                          placeholder="توضیح کوتاه   . . .">{{old('long_description')}} </textarea>
                            </div>
                        </div>
                        <div class="line-dashed"></div>

                        <div class="lg-row" id="holder">
                            <img src="">
                        </div>

                        <div class="col-md-6">
                            <h2 class="mt-4">تصویر اصلی محصول</h2>
                            <div class="input-group">
                          <span class="input-group-btn">
                     <a id="image" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                            <i class="fa fa-picture-o"></i> انتخاب
                            </a>
                                </span>
                                <input id="thumbnail" class="form-control" type="text" name="image">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h2 class="mt-4"> تصاویر محصول</h2>
                            <div class="input-group">
                          <span class="input-group-btn">
                     <a id="images" data-input="thumbnails" data-preview="holder2" class="btn btn-primary text-white">
                            <i class="fa fa-picture-o"></i> انتخاب
                            </a>
                                </span>
                                <input id="thumbnails" class="form-control" type="text" name="images">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h2 class="mt-4">تصویر سایز</h2>
                            <div class="input-group">
                          <span class="input-group-btn">
                     <a id="image_size" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                            <i class="fa fa-picture-o"></i> انتخاب
                            </a>
                                </span>
                                <input id="thumbnail" class="form-control" type="text" name="image_size">
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <div class="col-sm-12" id="holder2">
                                <img src="" alt="">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <button class="btn btn-success" type="submit">ثبت</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="{{asset('admin/js/form.js')}}"></script>

    <script src="{{asset('/vendor/laravel-filemanager/js/stand-alone-button.js')}}" defer></script>

    <script>
        $(".select2").select2();
        FormURL = '{{route('admin.products.store')}}';
        METHOD = 'post';
    </script>

    <script>
        {

            const addFeature = document.querySelector('#addFeature');
            const selects = document.querySelector('#selectjs');
            let res = "";
            document.querySelector('#category_id').onchange = () => {
                doSearch();
            }

            const doSearch = () => {

                let url = new URL('{{route('admin.products.featuresSelect')}}');
                const data = new FormData(document.querySelector('#form-st'));
                data.forEach((value, key) => {
                    if (value != ' ' && value !== 'file') {
                        url.searchParams.append(key, value);
                    }

                });


                spa.sendRequest(url.href, 'get'
                ).then(resolve => {
                    if (resolve.status == 200 || resolve.status == 201) {

                        resolve = resolve.response
                        document.querySelector('.table-responsive').innerHTML = resolve
                        selects.hidden = false;
                        addFeature.hidden = false;
                        spa.executeSpaLinks();
                        spa._executeScripts();

                        res = resolve;
                    }
                }).catch(err => {
                    if (err.status != 200 || err.status != 201) {
                        console.debug(err)
                        //alert('خطا رخ داده است.')
                    }
                })

                document.querySelector('#addFeatureField').onclick = () => {
                    addElements(res);
                }
            }
        }

    </script>


    <script>

        function addElements(res) {
            const selects = document.querySelector('#selectjs');
            const featureEl = document.createElement('div');

            selects.appendChild(featureEl);
            featureEl.innerHTML += res
            $('.select2').select2();
        }


        const removeFeatureField = document.querySelector('#removeFeatureField');
        removeFeatureField.onclick = () => {
            if (document.querySelector('#selectjs').childElementCount > 1) {
                document.querySelector('#selectjs').lastChild.remove();
            }
        }
    </script>



    {{--image--}}
    <script>
        var lfm = function (id, type, options) {
            let button = document.getElementById(id);

            button.addEventListener('click', function () {
                var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
                var target_input = document.getElementById(button.getAttribute('data-input'));
                window.open(route_prefix + '?type=' + type || 'file', 'FileManager', 'width=900,height=600');
                window.SetUrl = function (items) {
                    var file_path = items.map(function (item) {
                        return item.url;
                    }).join('/|\\,');

                    // set the value of the desired input to image url
                    target_input.value = file_path;
                    target_input.dispatchEvent(new Event('change'));


                    // set or change the preview image src
                    if (button.getAttribute('data-preview')) {
                        var target_preview = document.getElementById(button.getAttribute('data-preview'));
                        // clear previous preview
                        target_preview.innerHtml = '';
                        var imgs = '';
                        items.forEach(function (item) {
                            let img = `<img src="${item.thumb_url}" style="height: 150px; margin-right: 5px;margin-bottom: 5px">`;
                            imgs += img;
                        });
                        target_preview.innerHTML = imgs;
                        // trigger change event
                        target_preview.dispatchEvent(new Event('change'));
                    }
                };
            });
        };
        var route_prefix = "/laravel-filemanager";
        lfm('image', 'image', {prefix: route_prefix});
        lfm('images', 'images', {prefix: route_prefix});
        lfm('image_size', 'image_size', {prefix: route_prefix});
    </script>


    {{--editor--}}
    <script>
        var editor_config = {
            path_absolute: "/",
            height: "400px",
            selector: "textarea.my-editor",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            file_browser_callback: function (field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                    'body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no"
                });
            }
        };

        tinymce.init(editor_config);
    </script>



    <script>
        const addFields = document.querySelector('#addFieldsButton');
        const removeFields = document.querySelector('#removeFieldsBotton');
        addFields.onclick = () => {
            const selects = document.querySelector('#addFields');
            const fieldsEl = document.createElement('div');
            fieldsEl.innerHTML += `  <div class="lg-row">
                                <div class="col-sm-3">
                                    <label for="size">سایز</label>
                                    <input value='{{old('size')}}' id='size[]' name='size[]'
                                           type="text"
                                           class="form-control" placeholder="سایز. . .">
                                </div>
                                <div class="col-sm-3">
                                    <label for="color">رنگ</label>
                                    <input value=' ' id='color[]' name='color[]'
                                           type="color"
                                           class="form-control" placeholder="رنگ. . .">
                                </div>
                                  <div class="col-sm-3">
                                    <label for="count">تعداد</label>
                                    <input value='{{old('count')}}' id='count[]' name='count[]'
                                           type="number" min="1"
                                           class="form-control" placeholder="تعدا. . .">
                                </div>
                                <div class="col-sm-3">
                                    <label for="price">قیمت</label>
                                    <input value='{{old('price')}}' id='price[]' name='price[]'
                                           type="text"
                                           class="form-control" placeholder="قیمت. . .">
                                </div>
                            </div>`;
            selects.appendChild(fieldsEl);
        }

        removeFields.onclick = () => {
            if (document.querySelector('#addFields').childElementCount > 1) {
                document.querySelector('#addFields').lastChild.remove();
            }
        }

    </script>
@endsection
