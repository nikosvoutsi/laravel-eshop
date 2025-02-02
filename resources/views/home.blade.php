@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="col-12" style="height: 100%; overflow: auto;width: 70%; margin: 0 auto; text-align: center;">
        <form action="/search_results" method="get" style="margin: 100px 0;">
            <div class="input-group mb-3">
                <input type="search" class="form-control form-control-lg" placeholder="Search for a Product" required
                       aria-label="Search for a Product" aria-describedby="search-button" name="search">
                <button class="btn btn-primary" type="submit" id="search-button">Search</button>
            </div>
        </form>
        <h4>Or navigate by category:</h4>
        <br>
        <div class="card-container d-flex justify-content-center" style="flex-wrap: wrap;">
            @foreach($categories as $category)
            <a href="{{ route('category.show', ['category_id' => $category->category_id]) }}"
                class="card align-items-center d-flex justify-content-center"
                style="width: 30%; height: 150px; margin: 1%; text-decoration: none; color: #000; font-size: 1.2em; background-color: {{$category->color}} ">
                 <span>{{ $category->title }}</span>
             </a>
            @endforeach
        </div>
        <br>
        <a href="{{ route('business.register') }}" class="btn btn-outline-primary">Register Your Business</a>
        <br>
        <br>
    </div>
</div>

<style>
    a.card :hover{
        opacity: 0.7; 
    }
</style>
@endsection