<div class="text-container new">
    <textarea name="content[]" rows="8" placeholder="Insert text here!" onfocusout="this.placeholder = 'Insert text here!'" autocomplete="off" required>{{ old("content[]") }}</textarea>
    <div class="overlay">
        <div id="edit" class="menu-item">
            <svg>
                <use xlink:href="{{ secure_asset('images/graphics/pen.svg#icon') }}"></use>
            </svg>
        </div>
        <div id="move" class="menu-item">
            <svg>
                <use xlink:href="{{ secure_asset('images/graphics/move.svg#icon') }}"></use>
            </svg>
        </div>
        <div id="delete" class="menu-item" >
            <svg>
                <use xlink:href="{{ secure_asset('images/graphics/delete.svg#icon') }}"></use>
            </svg>
        </div>
    </div>
    @if($editing == true)
    <input name="content[][to_delete]" type="checkbox" hidden>
    @endif
</div>
