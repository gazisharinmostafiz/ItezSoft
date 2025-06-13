{{-- File: resources/views/about.blade.php --}}
@extends('layouts.app')

@section('title', 'About Us - ' . ($globalSiteName ?? config('app.name', 'ItezSoft')))

@section('content')
<div class="bg-white py-12 md:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <header class="mb-8 text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 leading-tight">
                    About ItezSoft
                </h1>
                <p class="mt-4 text-xl text-gray-600">
                    Driving Digital Excellence and Innovation.
                </p>
            </header>

            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                <p>Welcome to ItezSoft! We are a passionate team dedicated to providing top-notch digital solutions, including innovative software development, creative graphics design, and cutting-edge web design services. Our mission is to empower businesses by leveraging technology and design to achieve their goals and enhance their online presence.</p>

                <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">Our Vision</h2>
                <p>To be a leading digital solutions provider recognized for our creativity, reliability, and commitment to client success. We aim to build long-lasting partnerships by consistently delivering exceptional value and exceeding expectations.</p>

                <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">Our Team</h2>
                <p>Our diverse team of experts brings together a wealth of experience from various fields of technology and design. We thrive on collaboration and are constantly exploring new trends and techniques to stay at the forefront of the digital landscape. [You can add more details about your team here or link to a team section if you create one].</p>

                {{-- You can later convert this page to be managed by the dynamic "Pages" system if you create an "about-us" slug entry --}}
            </div>
        </div>
    </div>
</div>
@endsection