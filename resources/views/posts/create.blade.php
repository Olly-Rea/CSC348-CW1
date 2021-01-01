@extends('layouts.app')

@section("styles")
<link href="{{ asset('css/post-edit.css') }}" rel="stylesheet">
@endsection

@section("jquery")
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" defer></script>
@endsection

@section("scripts")
<script src="{{ asset('javascript/post_forms/global.js') }}" defer></script>
<script src="{{ asset('javascript/post_forms/create.js') }}" defer></script>
@endsection

@section('title')
<title>{{ config('app.name', 'Laravel') }}</title>
@endsection

@section('content')
<form id="post-form" method="POST" action="{{ route('post.save') }}" enctype="multipart/form-data">
    @csrf
    <div class="content-panel">
        <input name="title" type="text" placeholder="Insert title here..." onfocusout="this.placeholder = 'Insert title here...'" value="{{ old("title") }}" autocomplete="off" required/>
        @if ($errors->has('title')) <p class="form-error-msg">{{ $errors->first('title') }}</p> @endif
        <div class="tag-container">
            <p id="tag-selector">No Tags!</p>
        </div>
        @if ($errors->has('tags')) <p class="form-error-msg">{{ $errors->first('tags') }}</p> @endif
    </div>
    @if(old("content"))
    @foreach(old("content") as $content)
    <div class="text-container">
        <textarea name="content[]" rows="8" placeholder="Insert text here!" onfocusout="this.placeholder = 'Insert text here!'" autocomplete="off">{{ $content }}</textarea>
        <div class="overlay">
            <div id="edit" class="menu-item">
                <svg>
                    <use xlink:href="{{ asset('images/graphics/pen.svg#icon') }}"></use>
                </svg>
            </div>
            <div id="move" class="menu-item">
                <svg>
                    <use xlink:href="{{ asset('images/graphics/move.svg#icon') }}"></use>
                </svg>
            </div>
            <div id="delete" class="menu-item" >
                <svg>
                    <use xlink:href="{{ asset('images/graphics/delete.svg#icon') }}"></use>
                </svg>
            </div>
        </div>
    </div>
    @if($errors->has('content')) <p class="form-error-msg">{{ $errors->first('content') }}</p>@endif
    @if($errors->has('content.*')) <p class="form-error-msg">{{ $errors->first('content.*') }}</p>@endif
    @endforeach
    @else
    <div class="image-container">
        <svg>
            <use xlink:href="{{ asset('images/graphics/image.svg#icon') }}"></use>
        </svg>
        <img src="">
        <div class="overlay">
            <label id="edit" class="menu-item">
                <input type="file" name="content[]" accept=".jpg, .jpeg, .png, .bmp">
                <span>
                    <svg>
                        <use xlink:href="{{ asset('images/graphics/pen.svg#icon') }}"></use>
                    </svg>
                </span>
            </label>
            <div id="move" class="menu-item">
                <svg>
                    <use xlink:href="{{ asset('images/graphics/move.svg#icon') }}"></use>
                </svg>
            </div>
            <div id="delete" class="menu-item" >
                <svg>
                    <use xlink:href="{{ asset('images/graphics/delete.svg#icon') }}"></use>
                </svg>
            </div>
        </div>
    </div>
    @if($errors->has('content')) <p class="form-error-msg">{{ $errors->first('content') }}</p>@endif
    @if($errors->has('content.*')) <p class="form-error-msg">{{ $errors->first('content.*') }}</p>@endif
    <div class="text-container">
        <textarea name="content[]" rows="8" placeholder="Insert text here!" onfocusout="this.placeholder = 'Insert text here!'" autocomplete="off" required>{{ old("content[]") }}</textarea>
        <div class="overlay">
            <div id="edit" class="menu-item">
                <svg>
                    <use xlink:href="{{ asset('images/graphics/pen.svg#icon') }}"></use>
                </svg>
            </div>
            <div id="move" class="menu-item">
                <svg>
                    <use xlink:href="{{ asset('images/graphics/move.svg#icon') }}"></use>
                </svg>
            </div>
            <div id="delete" class="menu-item" >
                <svg>
                    <use xlink:href="{{ asset('images/graphics/delete.svg#icon') }}"></use>
                </svg>
            </div>
        </div>
    </div>
    @if($errors->has('content')) <p class="form-error-msg">{{ $errors->first('content') }}</p>@endif
    @if($errors->has('content.*')) <p class="form-error-msg">{{ $errors->first('content.*') }}</p>@endif
    @endif
</form>

<div class="screen-split-horizontal"></div>

<div id="form-nav">
    <div id="add-text" class="menu-item">
        <div>
            <svg>
                <use xlink:href="{{ asset('images/graphics/text.svg#icon') }}"></use>
            </svg>
        </div>
        <h1>Text</h1>
    </div>
    <div id="add-image" class="menu-item">
        <div>
            <svg>
                <use xlink:href="{{ asset('images/graphics/image.svg#icon') }}"></use>
            </svg>
        </div>
        <h1>Image</h1>
    </div>
    <label id="save" class="menu-item">
        <div>
            <input type="submit" form="post-form">
            <svg>
                <use xlink:href="{{ asset('images/graphics/save.svg#icon') }}"></use>
            </svg>
        </div>
        <h1>Save</h1>
    </label>
    <div id="publish" class="menu-item" >
        <div>
            <svg>
                <use xlink:href="{{ asset('images/graphics/about.svg#icon') }}"></use>
            </svg>
        </div>
        <h1>Publish</h1>
    </div>
</div>

@endsection

@section('overlays')
<div id="exit" class="prompt" style="display: none">
    <h1>Are you sure you want to exit?</h1>
    <p>Any unsaved changes will be lost!</p>
    <button>Yes</button>
    <p class="cancel-prompt">Cancel</p>
</div>
<div id="tags" class="prompt" style="display: none">
    <h1>Select relevent tags:</h1>
    <div id="relevent-tags">
    @if(old('tags'))
        @foreach ($tags as $tag)
        <label class="checkOption">
            <input form="post-form" type="checkbox" name="tags[]" value="{{ $tag->name }}" @if(in_array($tag->name, old('tags'))) checked @endif/>
            <span class="checkbox">
                <svg>
                    <use xlink:href="{{ asset('images/graphics/checkbox.svg#icon') }}"></use>
                </svg>
                {{ $tag->name }}
            </span>
        </label>
        @endforeach
    @else
        @foreach ($tags as $tag)
        <label class="checkOption">
            <input form="post-form" type="checkbox" name="tags[]" value="{{ $tag->name }}"/>
            <span class="checkbox">
                <svg>
                    <use xlink:href="{{ asset('images/graphics/checkbox.svg#icon') }}"></use>
                </svg>
                {{ $tag->name }}
            </span>
        </label>
        @endforeach
    @endif
    </div>
    <p class="close-prompt">Close</p>
</div>
@endsection
