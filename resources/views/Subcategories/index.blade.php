@extends('app')
@section('content')
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Sub-Categories</h5>
                <!--end::Page Title-->
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
            </div>
            <!--end::Toolbar-->
        </div>
    </div>
    <!--end::Subheader-->
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <!--  Begin Page Content -->
                <div class="container-fluid">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"> Sub-Categories List
                                <a  href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm float-right"
                                    data-toggle="modal" data-target="#modalsubCategoryForm">Add Sub-Categories</a>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>category</th>
                                        <th>Banner Image</th>
                                        <th>Square Image</th>
                                        <th>action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($subcategories as $subcategory)
                                        <tr>
                                            <td>{{$subcategory->name}}</td>
                                            <td>{{$subcategory->category->name}}</td>
                                            <td><img src="{{asset($subcategory->banner_image)}}" height="150px" width="150px" class="ml-5"></td>
                                            <td><img src="{{$subcategory->square_image}}" height="150px" width="150px" class="ml-5"></td>
                                            <td>
                                                <a class="btn btn-sm" onclick="editCategory({{$subcategory->id}})"><i class="fas fa-edit"></i></a>
                                                <a class="btn  delete btn-sm"  href="{{url('delete_subCategory/' .$subcategory->id) }}"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Main Content -->
            </div>
        </div>
    </div>
    <!-- /////////////////////////////////////////...........create model SubCategory form ..........////////////////-->
    <div class="modal fade" id="modalsubCategoryForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Add Sub-categories</h4>
                </div>
                <form class="form" novalidate="novalidate"  action="{{route('add_subCategories')}}" method="Post" autocomplete="off" enctype="multipart/form-data" id="kt_subcategory_add_form">
                    @csrf
                    <div class="modal-body mx-3">
                        <div class="form-group">
                            <label for="name">Your name</label>
                            <input type="text" id="name" name="name"  placeholder="Enter Your Name" class="form-control validate">
                        </div>
                        <div class="form-group">
                            <label for="name">Category</label>
                            <select class="form-control" name="category_id" id="category_id">
                                {{$categories}}
                                @foreach($categories as $category)
                                    <option {{ isset($detail->category_id)&&$detail->category_id == $category->name?'selected':"" }} value="{{ $category->id }}">{{ $category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="banner_image">Banner Image</label>
                            <input type="file" id="banner_image"  class="form-control validate" name="banner_image" placeholder="banner_image">

                        </div>
                        <div class="form-group">
                            <label  for="square_image">Square Image</label>
                            <input type="file" id="square_image" name="square_image" placeholder="square_image" class="form-control validate">
                        </div>
                        <div class=" d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-user btn-block" id="kt_subcategory_submit">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /////////////////////////////////////////...........EditCategory model  form ..........////////////////-->
    <div class="modal fade" id="modalEditForm" tabindex="-1" role="dialog" aria-labelledby="modalEditForm"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold" id="modalEditForm">Edit categories</h4>
                </div>
                <!--begin::Form-->
                <form class="form" method="POST" action="{{route('update_subcategories')}}" novalidate="novalidate" id="kt_subcategory_edit_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="subcategory_id" name="id"  class="form-control">
                    <!--begin::Form group-->
                    <div class="modal-body mx-3">
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark" for="category_name">Name</label>
                            <input type="text" id="subcategory_name" name="name"  placeholder="Enter Your Name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="name">Category</label>
                            <select class="form-control" name="category_id" id="editcategory_id">
                                {{$categories}}
                                @foreach($categories as $category)
                                    <option {{ isset($detail->category_id)&&$detail->category_id == $category->name?'selected':"" }} value="{{ $category->id }}">{{ $category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark" for="banner_picture">Banner Image</label>
                            <input type="file" id="banner_picture" name="banner_image" placeholder="Banner Image" class="form-control validate">
                            <img src="" class="mt-4" id="edit_banner_image" height="150px" width="150px">
                        </div>
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark" for="square_picture">Square Image</label>
                            <input type="file" id="square_picture" name="square_image" placeholder="Square Image" class="form-control validate">
                            <img src="" class="mt-4" id="edit_square_image" height="150px" width="150px">
                        </div>
                        <div class=" d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-user btn-block" id="kt_subcategory_update_submit">
                                Submit
                            </button>
                        </div>
                    </div>
                    <!--end::Action-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{asset('assets/js/subCategoriesValidation.js')}}"></script>
    <!--end::Page Scripts-->
    <script>
        setTimeout(() => {
            $('.alert').alert('close');
        }, 2000);

        $("#banner_picture").on('change' ,function (e){
            $("#edit_banner_image").attr("src", URL.createObjectURL(e.target.files[0]));
        })
        $("#square_picture").on('change' ,function (e){
            $("#edit_square_image").attr("src", URL.createObjectURL(e.target.files[0]));
        })

        function editCategory(id)
        {

            $.ajax({
                url:"{{ url('edit/subcategory') }}"+"/"+id,
                success:function (data) {
                    $("#subcategory_id").val(data.id);
                    console.log(data.id);
                    $("#subcategory_name").val(data.name);
                    $("#editcategory_id").val(data.category_id);
                    $("#edit_banner_image").attr("src",data.banner_image);
                    $("#edit_square_image").attr("src",data.square_image);
                    $("#modalEditForm").modal("show");
                }
            })
        }
    </script>
@endsection
