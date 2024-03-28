<x-layout>
    <h1>login</h1>

    {{--
        <form action="{{ route('users.store') }}" method="POST">
        @csrf
        
        @if ($errors->any())
        <div class="error-messages">
        <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        </ul>
        </div>
        @endif
        
        <label for="date">Name:</label>
        <input type="date" id="date" name="date" />
        
        <label for="vendor">Email:</label>
        <input type="text" id="vendor" name="vendor" />
        
        <label for="spend">Password:</label>
        <input type="text" id="spend" name="spend" />P
        
        
        <input type="submit" value="Submit" />
        </form>
    --}}
</x-layout>
