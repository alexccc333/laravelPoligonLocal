<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </div>
</div>
<br>

@if($item->exists)
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul class="list-unstyled">
                       <li>ID:{{$item->id}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Создано</label>
                        <input type="text" name="title" value="{{$item->created_at}}" class="form-control" disabled
                               aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label for="title">Изменено</label>
                        <input type="text" name="title" value="{{$item->updated_at}}" class="form-control" disabled
                               aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label for="title">Удаленно</label>
                        <input type="text" name="title" value="{{$item->deleted_at}}" class="form-control" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
@endif
