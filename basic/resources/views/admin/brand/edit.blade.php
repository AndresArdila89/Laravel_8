<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Brand
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header"> Edit Brand</div>
                        <div class="card-body">
                            <form action="{{ url('/brand/update/'.$brands->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf 
				<input type="hidden" name='old_image' value="{{ $brands->brand_image}}"> 
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label">Brand Name</label>
                                    <input type="text" class="form-control" name="brand_name" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $brands->brand_name }}">
                                    @error('brand_name')
                                        <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label">Brand Image</label>
                                    <input type="file" class="form-control" name="brand_image" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$brands->brand_image}}">
                                    @error('brand_image')
                                        <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>
				<div class="form-group mt-4">
					<img src="{{ asset($brands->brand_image)}}" style="height:80px; width:240px;">
				</div>
                                <button type="submit" class="btn btn-primary mt-4">Update Brand</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div> {{-- Container END --}}
    </div>
</x-app-layout>