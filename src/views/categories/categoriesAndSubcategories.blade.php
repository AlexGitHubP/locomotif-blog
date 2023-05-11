
<form id='addProductsCategoriesAndSubcategories' method="POST" action='' class='spaced-form'>
    @csrf
    <input type="hidden" name="pid" id='pid' value='{{$parent_id}}'>
    
    @foreach ($categories as $key => $category )
        <div class='subcategoryHold'>
            <div class="input-element checkbox-input">
                <label for="category_{{$category->category_url}}">{{$category->category_name}}</label>
                <input type="checkbox" {{ $category->selected==true ? 'checked' : '' }} name="categories[]" id='category_{{$category->category_url}}' value="{{$category->id}}">
                <div class='fakecheck'></div>
            </div>
            
            @foreach ( $category->subcategories as $kk => $subcategory )
                <div class="input-element checkbox-input isSubcategory">
                    <label for="subcategory_{{$subcategory->subcategory_url}}">{{$subcategory->subcategory_name}}</label>
                    <input type="checkbox" {{ $subcategory->selected==true ? 'checked' : '' }} name="subcategories[]" id='subcategory_{{$subcategory->subcategory_url}}' value="{{$subcategory->id}}" data-parent='category_{{$category->category_url}}'>
                    <div class='fakecheck'></div>
                </div>
            @endforeach
        </div>
    @endforeach
    
    <input data-tableName='' data-formID='addProductsCategoriesAndSubcategories' data-submitUrl='/admin/blogCategories/addCategoriesAndSubcategories' class='general-btn ajaxSubmit' type="submit" value="Asociază categoriile">
</form>
    