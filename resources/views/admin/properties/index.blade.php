@extends('layouts.admin')

@section('title', 'Properties - Admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Properties</h2>
        <a href="{{ route('admin.properties.create') }}" class="btn btn-primary">
            <span class="btn-icon">+</span> Add New Property
        </a>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Price</th>
                    <th>Area</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($properties as $property)
                    <tr>
                        <td>{{ $property->title }}</td>
                        <td>{{ $property->type }}</td>
                        <td>
                            <span class="badge badge-{{ $property->is_archived ? 'danger' : 'success' }}">
                                {{ $property->is_archived ? 'Archived' : 'Active' }}
                            </span>
                        </td>
                        <td>${{ number_format($property->price) }}</td>
                        <td>{{ $property->area }} m²</td>
                        <td>{{ $property->location }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.properties.edit', $property) }}" class="btn btn-sm btn-secondary">
                                Edit
                            </a>
                            @if($property->is_archived)
                                <form action="{{ route('admin.properties.unarchive', $property) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success">
                                        Unarchive
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.properties.archive', $property) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-warning">
                                        Archive
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.properties.destroy', $property) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this property?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No properties found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $properties->links() }}
    </div>
</div>

<style>
    .card {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 24px;
        margin-bottom: 24px;
    }
    
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border-color);
    }
    
    .card-title {
        font-size: 24px;
        font-weight: 600;
        color: var(--text-color);
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 16px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        background-color: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .btn-icon {
        margin-right: 8px;
        font-size: 16px;
    }
    
    .btn-secondary {
        background-color: #6c757d;
    }
    
    .btn-secondary:hover {
        background-color: #5a6268;
    }
    
    .btn-success {
        background-color: #28a745;
    }
    
    .btn-success:hover {
        background-color: #218838;
    }
    
    .btn-warning {
        background-color: #ffc107;
        color: #212529;
    }
    
    .btn-warning:hover {
        background-color: #e0a800;
    }
    
    .btn-danger {
        background-color: #dc3545;
    }
    
    .btn-danger:hover {
        background-color: #c82333;
    }
    
    .btn-sm {
        padding: 6px 12px;
        font-size: 12px;
    }
    
    .table-container {
        overflow-x: auto;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table th,
    .table td {
        padding: 16px;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }
    
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #495057;
    }
    
    .table tr:last-child td {
        border-bottom: none;
    }
    
    .table tr:hover {
        background-color: rgba(0, 102, 255, 0.05);
    }
    
    .actions {
        display: flex;
        gap: 8px;
    }
    
    .badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .badge-success {
        background-color: #d4edda;
        color: #155724;
    }
    
    .badge-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 24px;
    }
    
    .pagination a {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        color: var(--text-color);
        text-decoration: none;
        transition: all 0.3s;
        margin: 0 4px;
    }
    
    .pagination a:hover {
        background-color: var(--light-gray);
    }
    
    .pagination .active {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    
    .inline {
        display: inline-block;
    }
    
    .text-center {
        text-align: center;
    }
</style>
@endsection 