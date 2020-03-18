@extends('layouts.app')


@section('content')
    @php
        /** @var \App\Models\BlogPost $item **/
    @endphp


    @include('blog.admin.posts.includes.result_messages')
    <div class="container">
        @if($item->exists)
            <form action="{{route('blog.admin.posts.update',$item->id)}}" method="POST">
                @method('PATCH')
                @else
                    <form action="{{route('blog.admin.posts.store')}}" method="POST">
                        @endif
                        @csrf
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    @include('blog.admin.posts.includes.post_edit_main_col')
                                </div>
                                <div class="col-md-4">
                                    @include('blog.admin.posts.includes.post_edit_add_col')
                                </div>
                            </div>
                        </div>
                    </form>
            </form>
    </div>

    @if ($item->exists)
        <br>

        <form action="{{route('blog.admin.posts.destroy',$item->id)}}" method="POST" class="mt-5">
            @method('DELETE')
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-block">
                        <div class="card-body ml-auto">
                            <button class="btn btn-link" type="submit">Удалить</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </form>
    @endif
@endsection
