@php
    /** @var \App\Models\BlogCategory $item **/
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#maindata" role="tab">Основные данные</a>
                        </li>
                    </ul>
                    <br>
                    <div class="tab-content">
                        <div class="tab-pane active" id="maindata" role="tabpanel">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="title">Название</label>
                                    <input type="text"
                                           name="title"
                                           id="title"
                                           value="{{$item->title}}"
                                           class="form-control"
                                           required
                                           minlength="3"
                                           aria-describedby="helpId">
                                    <small id="helpId" class="text-muted">Help text</small>
                                </div>

                                <div class="form-group">
                                    <label for="slug">Слаг</label>
                                    <input type="text"
                                           name="slug"
                                           value="{{$item->slug}}"
                                           id="slug"
                                           class="form-control"
                                           aria-describedby="helpId">
                                    <small id="helpId" class="text-muted">Help text</small>
                                </div>

                                <div class="form-group">
                                    <label for="parent_id">Родитель</label>
                                    <select class="form-control" name="parent_id" id="parent_id">
                                        @foreach($categoryList as $categoryOption)
                                            <option value="{{$categoryOption->id}}"
                                                    @if($categoryOption->id == $item->parent_id) selected @endif>
                                                {{$categoryOption->id_title}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="description">Описание</label>
                                    <textarea name="description"
                                              id="description"
                                              class="form-control"
                                              rows="3"
                                              aria-describedby="helpId">
                                        {{old('description',$item->description)}}
                                    </textarea>
                                    <small id="helpId" class="text-muted">Help text</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
