@extends('layouts.app')

@section("styles")
<link href="{{ asset('css/post-edit.css') }}" rel="stylesheet">
@endsection

@section("jquery")
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" defer></script>
@endsection

@section("scripts")
<script src="{{ asset('javascript/post_forms/global.js') }}" defer></script>
<script src="{{ asset('javascript/post_forms/edit.js') }}" defer></script>
@endsection

@section('content')
<form id="post-form" method="POST" action="{{ route('post.update', $post) }}" enctype="multipart/form-data">
    @csrf
    <input id="publish-input" name="publish" type="number" value="{{ $post->published }}" hidden>
    <div class="content-panel">
        <input id="title-input" name="title" type="text" placeholder="Insert title here..." onfocusout="this.placeholder = 'Insert title here...'" value="{{ old('title') ? old('title') : $post->title }}" autocomplete="off" required/>
        @if ($errors->has('title')) <p class="form-error-msg">{{ $errors->first('title') }}</p> @endif
        <div class="tag-container">
            @forelse ($post->tags as $tag)
                <a href="#" class="{{ strtolower($tag->name) }}">{{ $tag->name }}</a>
            @empty
                <p id="tag-selector">No Tags!</p>
            @endforelse
        </div>
        @if ($errors->has('tags[]')) <p class="form-error-msg">{{ $errors->first('tags[]') }}</p> @endif
    </div>
    @if($errors->has('content[]')) <p class="form-error-msg">{{ $errors->first('content[]') }}</p>@endif
    @foreach($post->content as $key => $content)
        @if($content->type == 'text')
            <div class="text-container">
                <textarea name="content[][content]" rows="8" placeholder="Insert text here!" onfocusout="this.placeholder = 'Insert text here!'" autocomplete="off" required>{{ $content->content }}</textarea>
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
                {{-- Inputs to aid in post editing --}}
                <input name="content[][id]" type="number" value="{{ $content->id }}" hidden>
                <input name="content[][to_delete]" type="checkbox" hidden>
            </div>
            @if($errors->has('content.'.$key)) <p class="form-error-msg">{{ $errors->first('content.'.$key) }}</p>@endif
        @elseif($content->type == 'image')
            <div class="image-container">
                <svg>
                    <use xlink:href="{{ asset('images/graphics/image.svg#icon') }}"></use>
                </svg>
                <img src="{{ $content->loadImage() }}">
                <div class="overlay">
                    <label id="edit" class="menu-item">
                        <input type="file" name="content[][content]" accept=".jpg, .jpeg, .png, .bmp" value="filled">
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
                {{-- Inputs to aid in post editing --}}
                <input name="content[][id]" type="number" value="{{ $content->id }}" hidden>
                <input name="content[][to_delete]" type="checkbox" hidden>
            </div>
            @if($errors->has('content.'.$key)) <p class="form-error-msg">{{ $errors->first('content.'.$key) }}</p>@endif
        @else
            <p>Unrecognised content!</p>
        @endif
    @endforeach
</form>
<form id="post-delete" action="{{ route('post.delete', $post->id) }}" method="POST" hidden>
    @csrf
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
    @if(!$post->published)
    <label id="publish" class="menu-item">
        <div>
            <input type="submit" form="post-form">
            <svg>
                <use xlink:href="{{ asset('images/graphics/publish.svg#icon') }}"></use>
            </svg>
        </div>
        <h1>Publish</h1>
    </label>
    @endif
    <div id="delete" class="menu-item" >
        <div>
            <svg>
                <use xlink:href="{{ asset('images/graphics/delete.svg#icon') }}"></use>
            </svg>
        </div>
        <h1>Delete</h1>
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
            <input form="post-form" type="checkbox" name="tags[]" value="{{ $tag->name }}" @if(in_array($tag->name, old('tags')) || $post->tags->contains('name', $tag->name))checked @endif/>
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
            <input form="post-form" type="checkbox" name="tags[]" value="{{ $tag->name }}" @if($post->tags->contains('name', $tag->name))checked @endif/>
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
