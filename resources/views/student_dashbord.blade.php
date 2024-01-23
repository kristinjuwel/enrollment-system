<!-- student_dashboard.blade.php -->

<div class="container">
    <h1>Welcome to the Student Dashboard</h1>

    <!-- Subject search form -->
    <form method="GET" action="{{ route('subject.search') }}">
        <div class="mb-3">
            <label for="search_subject" class="form-label">Search Subject</label>
            <input type="text" class="form-control" id="search_subject" name="search_subject" required>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <!-- Display search results -->
    <h2>Search Results</h2>
    @if($searchResults->isEmpty())
        <p>No subjects found.</p>
    @else
        <ul>
            @foreach($searchResults as $subject)
                <li>
                    {{ $subject->course_name }} - Slots: {{ $subject->slots }}
                    @if($subject->enrolledStudents->count() < $subject->slots)
                        <form method="POST" action="{{ route('cart.add', ['subjectId' => $subject->id]) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Add to Cart</button>
                        </form>
                    @else
                        <span>Subject is full</span>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif

    <!-- Display the cart -->
    <h2>Cart</h2>
    @if($cart->isEmpty())
        <p>Cart is empty.</p>
    @else
        <ul>
            @foreach($cart as $subject)
                <li>
                    {{ $subject->course_name }}
                    <form method="POST" action="{{ route('cart.remove', ['subjectId' => $subject->id]) }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                    </form>
                </li>
            @endforeach
        </ul>
        <form method="POST" action="{{ route('cart.checkout') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Checkout</button>
        </form>
    @endif
</div>
