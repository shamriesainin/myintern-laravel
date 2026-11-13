<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SECTION B: LIST OF CHOICES</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 p-4 md:p-8 font-sans">

    <div class="max-w-4xl mx-auto">
        <h2 class="text-blue-700 font-bold border-b-2 border-blue-700 pb-2 mb-4 text-2xl">SECTION B: LIST OF CHOICES</h2>

        @if(session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-3 py-2 rounded relative mb-4 text-sm">
                {{ session('message') }}
            </div>
        @endif

        <!-- SECTION 1: ADD/EDIT FORM -->
        <div class="bg-white mb-6 border-2 {{ $edit_choice ? 'border-yellow-500' : 'border-dashed border-blue-600' }} rounded-lg shadow-sm overflow-hidden text-sm">
            <div class="{{ $edit_choice ? 'bg-yellow-100' : 'bg-gray-100' }} px-4 py-2 font-bold flex justify-between items-center text-base">
                <div class="flex items-center">
                    <span class="{{ $edit_choice ? 'bg-yellow-500' : 'bg-blue-600' }} text-white rounded-full w-7 h-7 flex items-center justify-center mr-3">
                        {{ $edit_choice ? $edit_choice->choice_number : '+' }}
                    </span> 
                    {{ $edit_choice ? 'Edit Company Choice' : 'Add New Company' }}
                </div>
                @if($edit_choice)
                    <a href="{{ route('companies.index') }}" class="text-sm font-normal text-gray-600 underline hover:text-gray-900">Cancel Edit</a>
                @endif
            </div>
            
            <div class="p-4">
                <form method="POST" action="{{ $edit_choice ? route('companies.update', $edit_choice->id) : route('companies.store') }}">
                    @csrf
                    @if($edit_choice) @method('PUT') @endif
                    
                    <div class="md:grid md:grid-cols-[200px_1fr] gap-2 mb-2 items-center">
                        <div class="font-semibold">Name of company</div>
                        <div><input type="text" name="company_name" class="w-full py-1 px-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 outline-none" value="{{ $edit_choice->company_name ?? '' }}" required></div>
                    </div>

                    <div class="md:grid md:grid-cols-[200px_1fr] gap-2 mb-2 items-start">
                        <div class="font-semibold pt-1">Nature of company</div>
                        <div class="flex flex-wrap gap-x-4 gap-y-1 pt-1">
                            @php $nature = $edit_choice->company_nature ?? ''; @endphp
                            <label class="flex items-center"><input type="radio" name="company_nature" value="Government" {{ $nature == 'Government' ? 'checked' : '' }} required class="mr-1"> Government</label>
                            <label class="flex items-center"><input type="radio" name="company_nature" value="Private" {{ $nature == 'Private' ? 'checked' : '' }} class="mr-1"> Private</label>
                            <label class="flex items-center"><input type="radio" name="company_nature" value="Multinational" {{ $nature == 'Multinational' ? 'checked' : '' }} class="mr-1"> Multinational</label>
                            <label class="flex items-center"><input type="radio" name="company_nature" value="Others" {{ $nature == 'Others' ? 'checked' : '' }} class="mr-1"> Others</label>
                        </div>
                    </div>

                    <div class="md:grid md:grid-cols-[200px_1fr] gap-2 mb-2 items-start">
                        <div class="font-semibold pt-1">Address of company</div>
                        <div><textarea name="company_address" class="w-full py-1 px-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 outline-none" rows="2" required>{{ $edit_choice->company_address ?? '' }}</textarea></div>
                    </div>

                    <div class="md:grid md:grid-cols-[200px_1fr] gap-2 mb-2 items-start">
                        <div class="font-semibold pt-1">Core business</div>
                        <div><textarea name="core_business" class="w-full py-1 px-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 outline-none" rows="2" required>{{ $edit_choice->core_business ?? '' }}</textarea></div>
                    </div>

                    <div class="mt-3 text-right">
                        <button type="submit" class="{{ $edit_choice ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-blue-600 hover:bg-blue-700' }} text-white font-bold py-1.5 px-6 rounded transition text-sm">
                            {{ $edit_choice ? 'Update Choice' : 'Add New Choice' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <h3 class="text-blue-700 font-bold border-b-2 border-blue-700 pb-1 mb-3 text-lg mt-8">Added Companies</h3>

        <!-- SECTION 2: COMPACT LIST VIEW -->
        @if($companies->isEmpty())
            <p class="text-gray-600 italic text-sm">No companies added yet.</p>
        @endif

        <div class="flex flex-col gap-2"> 
            @foreach ($companies as $choice)
                <div class="bg-white border border-gray-200 rounded shadow-sm flex flex-col sm:flex-row overflow-hidden hover:bg-gray-50 transition">
                    <div class="bg-blue-100 text-blue-800 w-full sm:w-12 flex items-center justify-center font-bold text-lg border-b sm:border-b-0 sm:border-r border-gray-200 py-1 sm:py-0">
                        {{ $choice->choice_number }}
                    </div>
                    
                    <div class="p-2.5 flex-1 text-sm">
                        <div class="font-bold text-base text-gray-900 leading-tight">
                            {{ $choice->company_name }} 
                            <span class="text-xs font-normal text-gray-500 bg-gray-200 px-1.5 py-0.5 rounded ml-1 align-middle">{{ $choice->company_nature }}</span>
                        </div>
                        <div class="mt-1 text-gray-700 leading-snug"><span class="font-semibold">Core Business:</span> {{ $choice->core_business }}</div>
                        <div class="text-gray-700 leading-snug"><span class="font-semibold">Address:</span> {{ $choice->company_address }}</div>
                    </div>
                    
                    <div class="bg-gray-100 border-t sm:border-t-0 sm:border-l border-gray-200 p-2 flex sm:flex-col justify-center gap-1.5 min-w-[80px]">
                        <a href="{{ route('companies.index', ['edit_id' => $choice->id]) }}" class="bg-blue-500 text-white text-center w-full px-2 py-1 rounded text-xs font-bold hover:bg-blue-600 transition">Edit</a>
                        
                        <form method="POST" action="{{ route('companies.destroy', $choice->id) }}" class="m-0 w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white w-full px-2 py-1 rounded text-xs font-bold hover:bg-red-600 transition" onclick="return confirm('Delete this choice?');">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>