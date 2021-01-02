<div class="text-container new">
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
