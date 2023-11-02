@extends('back.layouts.pages-layout')
@section('pageTitle', isset($pageTitle)? $pageTitle :'Add new Post')
@section('content')

<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <div class="page-title">
                Add new Post
            </div>
        </div>
    </div>
</div>

<form action="{{ route ('author.posts.create')}}" method="post" id="addPostForm" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="row">

                <div class="col-md-9">
                    <div class="mb-3">
                        <label class="form-label">Post Title</label>
                        <input type="text" class="form-control" name="post_title" placeholder="Enter Post Title">
                        <span class="text-danger error-text post_title_error"></span>

                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Post Content</label>
                    <textarea class="form-control" name="post_content" rows="6" placeholder="Content.."></textarea>
                    <span class="text-danger error-text post_content_error"></span>
                </div>
                <div class="col-md-3">

                    <div class="mb-3">
                        <div class="form-label">Post Category</div>
                        <select class="form-select" name="post_category">
                            <option value="">No Selection</option>
                            @foreach(\App\Models\SubCategory::all() as $category)
                            <option value="{{$category->id}}" ->{{$category->subcategory_name}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text post_category_error"></span>
                    </div>

                    <div class="mb-3">
                        <div class="form-label">Featured Image</div>
                        <input type="file" class="form-control" name="featured_image">
                        <span class="text-danger error-text featured_image_error"></span>
                    </div>
                    <div class="image_holder mb-2" style="max-width: 250px;">
                        <img src="" alt="" class="img-thumbnail" id="image-previewer" data-ijabo-default-img="">

                    </div>
                    <button type="submit" class="btn btn-primary">Save Post</button>
                </div>
            </div>
        </div>
    </div>
</form>


@endsection
@push('script')
<script>
$('form#addPostForm').on('submit', function(e) {
    e.preventDefault();
    toastr.remove();
    var form = this;
    var post_content = CKEDITOR.instances.post_content.getData();
    var fromdata = new FormData(form);
    $.ajax({
        url: $(form).attr('action'),
        method: $(form).attr('method'),
        data: fromdata,
        processData: false,
        dataType: 'json',
        contentType: false,
        beforeSend: function() {
            $(form).find('span.error-text').text('');

        },
        success: function(response) {

            toastr.remove();
            if (response.code == 1) {
                $(form)[0].reset();
                $('div.image_holder').html('');
                toastr.success(response.msg);
            } else {
                toastr.error(response.msg);
            }

        },
        error: function(response) {
            toastr.remove();
            $.each(response, responseJSON.errors, function(prefix, val) {
                $(form).find('span' + prefix + '_error').text(val[0]);


            });
        }
    });

});
</script>

@endpush