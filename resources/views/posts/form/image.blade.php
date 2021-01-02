<div class="image-container new">
    <svg>
        <use xlink:href="{{ asset('images/graphics/image.svg#icon') }}"></use>
    </svg>
    <img src="">
    <div class="overlay">
        <label id="edit" class="menu-item">
            <input type='file' name='content[]' accept=".jpg, .jpeg, .png, .bmp">
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
