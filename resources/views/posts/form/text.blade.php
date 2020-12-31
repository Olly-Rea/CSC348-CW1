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
