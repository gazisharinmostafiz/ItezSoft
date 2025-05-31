<footer class="bg-gray-800 text-gray-300 py-12 mt-auto">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                {{-- Use globalSiteName for the footer site name --}}
                <h3 class="text-xl font-semibold text-white mb-4">{{ $globalSiteName ?? config('app.name', 'ItezSoft') }}</h3>
                <p class="text-sm">
                    Providing innovative software, graphics, and digital solutions to help your business thrive.
                </p>
                <p class="text-sm mt-2">Ilford, UK</p>
            </div>
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-indigo-400">Home</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-indigo-400">About Us</a></li>
                    <li><a href="{{ route('services.graphics') }}" class="hover:text-indigo-400">Services</a></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-indigo-400">Blog</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-indigo-400">Contact</a></li>
                </ul>
            </div>
  <div class="md:col-span-2 lg:col-span-1"> {{-- Adjusted column span for contact + social --}}
                <h4 class="text-lg font-semibold text-white mb-4">Connect With Us</h4>
                @if ($globalContactEmail)
                    <p class="text-sm mb-1">
                        <i class="fas fa-envelope fa-fw mr-2 opacity-75"></i><a href="mailto:{{ $globalContactEmail }}" class="hover:text-indigo-400">{{ $globalContactEmail }}</a>
                    </p>
                @endif
                @if ($globalContactPhone)
                    <p class="text-sm mb-4">
                        <i class="fas fa-phone fa-fw mr-2 opacity-75"></i><a href="tel:{{ $globalContactPhone }}" class="hover:text-indigo-400">{{ $globalContactPhone }}</a>
                    </p>
                @endif
                {{-- Social Media Icons --}}
                <div class="flex space-x-4 mt-2">
                    @if ($globalSocialFacebookUrl)
                        <a href="{{ $globalSocialFacebookUrl }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-indigo-400 transition-colors" title="Facebook">
                            <i class="fab fa-facebook-f fa-lg"></i>
                        </a>
                    @endif
                    @if ($globalSocialTwitterUrl)
                        <a href="{{ $globalSocialTwitterUrl }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-indigo-400 transition-colors" title="Twitter / X">
                            <i class="fab fa-twitter fa-lg"></i> {{-- Or fab fa-x-twitter for newer X icon --}}
                        </a>
                    @endif
                    @if ($globalSocialLinkedinUrl)
                        <a href="{{ $globalSocialLinkedinUrl }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-indigo-400 transition-colors" title="LinkedIn">
                            <i class="fab fa-linkedin-in fa-lg"></i>
                        </a>
                    @endif
                    @if ($globalSocialInstagramUrl)
                        <a href="{{ $globalSocialInstagramUrl }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-indigo-400 transition-colors" title="Instagram">
                            <i class="fab fa-instagram fa-lg"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-8 pt-8 border-t border-gray-700 text-center text-sm">
            {{-- Use globalFooterCopyright for the footer copyright text --}}
            <p>{!! $globalFooterCopyright ?? ('&copy; ' . date('Y') . ' ' . ($globalSiteName ?? config('app.name', 'itezsoft.com')) . '. All rights reserved.') !!}</p>
            <p class="mt-1">
                <a href="#" class="hover:text-indigo-400">Privacy Policy</a> |
                <a href="#" class="hover:text-indigo-400">Terms of Service</a>
            </p>
        </div>
    </div>
</footer>
