@extends('base')

@section('title', "Se connecter")

@section('content')

<div class=".max-w-lg.mx-auto.p-6.bg-white.rounded-lg.shadow-d">

@if($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
    <strong class="font-bold">Erreur !</strong>
    <span class="block sm:inline">{{ $errors->first() }}</span>
@endif


<form action="{{ route('login.submit')}}" method="POST" class="m-6">
@csrf
<div class="mb4">

<label for="email" class="block text-sm font-medium text-gray-700">Email</label>
<input class ="m-1 p-3 block w-1/6 border border-gray-300 outline-none rounded-md shadow-md" type="email" id="email" name="email" value=""{{old('email')}}>

@error('email')
<span class="text-red-500 text-sm">{{$message}}</span>
@enderror
</div>
<div class="mb4">

<label for="password" class="block text-sm font-medium text-gray-700">Password</label>
<input class ="m-1 p-3 block w-1/6 border border-gray-300 outline-none rounded-md shadow-md" type="password" id="password" name="password" value=""{{old('password')}}>

@error('password')
<span class="text-red-500 text-sm">{{$message}}</span>
@enderror
</div>

<button type="submit" class="w-1/6 py-2 px-4 bg-purple-700 hover:bg-purple-500 text-white rounded-md">Se connecter</button>

<p class="my-2">Pas encore de compte ?
    <a href="{{ route('registration.register')}}" class="text-red-500">S'inscrire dès maintenant</a>
</p>
</form>



</div>

@endsection