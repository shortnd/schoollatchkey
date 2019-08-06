<div class="card-body">
    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" id="first_name" class="form-control @error('first_name')is-invalid @enderror"
            wire:model.lazy="first_name" required>
        @error ('first_name')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        {{ $first_name }}
    </div>

    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" class="form-control @error('last_name')is-invalid @enderror"
            wire:model.lazy="last_name" required>
        @error ('last_name')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary" wire:click="saveChild">Add</button>
    </div>
</div>
