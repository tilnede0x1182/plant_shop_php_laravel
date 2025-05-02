@php($isEdit = isset($plant))
<form method="POST" action="{{ $isEdit ? route('admin.plants.update',$plant) : route('admin.plants.store') }}">
  @csrf @if($isEdit) @method('PUT') @endif
  <div class="mb-3"><label class="form-label">Nom</label><input class="form-control rounded-3" name="name" value="{{ old('name',$plant->name??'') }}"></div>
  <div class="mb-3"><label class="form-label">Prix (€)</label><input type="number" class="form-control rounded-3" name="price" value="{{ old('price',$plant->price??'') }}"></div>
  <div class="mb-3"><label class="form-label">Description</label><textarea class="form-control rounded-3" rows="3" name="description">{{ old('description',$plant->description??'') }}</textarea></div>
  <div class="mb-3"><label class="form-label">Stock</label><input type="number" class="form-control rounded-3" name="stock" value="{{ old('stock',$plant->stock??'') }}"></div>
  <button class="btn btn-warning rounded-3">{{ $isEdit ? 'Mettre à jour' : 'Créer' }}</button>
</form>
