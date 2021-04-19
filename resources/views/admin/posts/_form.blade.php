@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $message)
        <li>{{ $message }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="form-group">
    <label for="">Post Title</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $post->title) }}">
    @error('title')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>
<div class="form-group">
    <label for="">Category</label>
    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
        <option value="">No Category</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}" @if($category->id == old('category_id', $post->category_id)) selected @endif>{{ $category->name }}</option>
        @endforeach
    </select>
    @error('category_id')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>
<div class="form-group">
    <label for="">Content</label>
    <textarea rows="10" class="form-control @error('content') is-invalid @enderror" name="content">{{ old('content', $post->content) }}</textarea>
    @error('content')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>
<div class="form-group">
    <label for="">Image</label>
    @if ($post->image)
    <div>
        <img src="{{ $post->image_url }}" alt="">
    </div>
    @endif
    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
    @error('image')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>
<div class="form-group">
    <label for="">Status</label>
    <div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" value="draft" @if(old('status', $post->status) == 'draft') checked @endif>
            <label class="form-check-label">Draft</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" value="published"  @if(old('status', $post->status) == 'published') checked @endif>
            <label class="form-check-label" for="exampleRadios2">Published</label>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="">Tags</label>
    <div>
        @foreach ($tags as $tag)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="tag[]" value="{{ $tag->id }}" @if(in_array($tag->id, $post_tags)) checked @endif>
            <label class="form-check-label">{{ $tag->name }}</label>
        </div>
        @endforeach
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $saveLabel }}</button>
</div>