@props(['id', 'saved' => false, 'variant' => 'vacancy-preview'])

<form action="{{ route('student.bookmarks.store', $id) }}" method="POST" data-bookmark-form data-vacancy-id="{{ $id }}" data-saved="{{ $saved ? 'true' : 'false' }}">
    @csrf
    <input type="hidden" name="_method" value="DELETE" data-bookmark-method @unless($saved) disabled @endunless>
    <button type="submit" class="{{ $variant }}__bookmark" data-bookmark-button aria-label="{{ $saved ? 'Quitar de guardadas' : 'Guardar vacante' }}" aria-pressed="{{ $saved ? 'true' : 'false' }}" title="{{ $saved ? 'Quitar de guardadas' : 'Guardar vacante' }}">
        <img class="{{ $variant }}__bookmark-icon" data-bookmark-image
             src="{{ asset($saved ? 'images/BookmarkFilled.svg' : 'images/Bookmark.svg') }}" alt="">
    </button>
</form>
