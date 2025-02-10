<?php
use App\Config\Database;
$db =  Database::getInstance();
$conn = $db->connect();
exit;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location de Vacances Premium</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }
        .gradient-border {
            border: 2px solid;
            border-image: linear-gradient(45deg, #FF6B6B, #FFB88C) 1;
        }
        .hover-scale {
            transition: transform 0.3s ease-in-out;
        }
        .hover-scale:hover {
            transform: scale(1.03);
        }
        .card-shadow {
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.1);
        }
        .nav-link {
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: linear-gradient(to right, #FF6B6B, #FFB88C);
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .mega-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
        .group:hover .mega-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-rose-50 to-orange-50 min-h-screen">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass-effect border-b border-white border-opacity-20">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <i data-feather="home" class="w-8 h-8 text-rose-500"></i>
                    <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-rose-500 to-orange-500">
                        LuxStay
                    </span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <div class="group relative">
                        <a href="#" class="nav-link text-gray-700 hover:text-rose-500 transition-colors flex items-center">
                            Destinations
                            <i data-feather="chevron-down" class="w-4 h-4 ml-1"></i>
                        </a>
                        <!-- Mega Menu -->
                        <div class="mega-menu absolute top-full left-0 mt-2 w-80 glass-effect rounded-xl p-4 shadow-xl">
                            <div class="grid grid-cols-2 gap-4">
                                <a href="#" class="flex items-center space-x-2 p-2 hover:bg-white hover:bg-opacity-50 rounded-lg transition-colors">
                                    <i data-feather="map-pin" class="w-4 h-4 text-rose-500"></i>
                                    <span>France</span>
                                </a>
                                <a href="#" class="flex items-center space-x-2 p-2 hover:bg-white hover:bg-opacity-50 rounded-lg transition-colors">
                                    <i data-feather="map-pin" class="w-4 h-4 text-rose-500"></i>
                                    <span>Italie</span>
                                </a>
                                <a href="#" class="flex items-center space-x-2 p-2 hover:bg-white hover:bg-opacity-50 rounded-lg transition-colors">
                                    <i data-feather="map-pin" class="w-4 h-4 text-rose-500"></i>
                                    <span>Espagne</span>
                                </a>
                                <a href="#" class="flex items-center space-x-2 p-2 hover:bg-white hover:bg-opacity-50 rounded-lg transition-colors">
                                    <i data-feather="map-pin" class="w-4 h-4 text-rose-500"></i>
                                    <span>Grèce</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="nav-link text-gray-700 hover:text-rose-500 transition-colors">Offres</a>
                    <a href="#" class="nav-link text-gray-700 hover:text-rose-500 transition-colors">À propos</a>
                    <a href="#" class="nav-link text-gray-700 hover:text-rose-500 transition-colors">Contact</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    <button class="hidden md:block hover:text-rose-500 transition-colors">
                        <i data-feather="heart" class="w-6 h-6"></i>
                    </button>
                    <a href="/register" class="px-4 py-2 text-rose-500 hover:text-rose-600 transition-colors">
                        Connexion
                    </a>
                    <button class="px-4 py-2 bg-gradient-to-r from-rose-500 to-orange-500 text-white rounded-full hover:opacity-90 transition-opacity transform hover:-translate-y-0.5 duration-200">
                        Inscription
                    </button>
                    <!-- Mobile Menu Button -->
                    <button class="md:hidden text-gray-700 hover:text-rose-500 transition-colors">
                        <i data-feather="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation Menu -->
    <div class="hidden fixed inset-0 z-40 bg-black bg-opacity-50">
        <div class="fixed right-0 top-0 h-full w-64 glass-effect p-6 transform transition-transform duration-300">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-xl font-bold text-gray-800">Menu</h3>
                <button class="text-gray-700 hover:text-rose-500 transition-colors">
                    <i data-feather="x" class="w-6 h-6"></i>
                </button>
            </div>
            <div class="space-y-4">
                <a href="#" class="block text-gray-700 hover:text-rose-500 transition-colors py-2">Destinations</a>
                <a href="#" class="block text-gray-700 hover:text-rose-500 transition-colors py-2">Offres</a>
                <a href="#" class="block text-gray-700 hover:text-rose-500 transition-colors py-2">À propos</a>
                <a href="#" class="block text-gray-700 hover:text-rose-500 transition-colors py-2">Contact</a>
            </div>
        </div>
    </div>

    <!-- Reste du contenu existant avec un padding-top pour la nav fixe -->
    <div class="pt-20">
        <!-- Hero Section with Parallax -->
        <div class="relative overflow-hidden py-20 bg-gradient-to-r from-rose-400 to-orange-400">
            <div class="absolute inset-0 bg-black bg-opacity-30"></div>
            <div class="absolute -top-48 -left-48 w-96 h-96 bg-rose-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float"></div>
            <div class="absolute -bottom-48 -right-48 w-96 h-96 bg-orange-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float" style="animation-delay: 1s"></div>
            
            <div class="container mx-auto px-4 relative z-10">
                <div class="max-w-4xl mx-auto text-center text-white">
                    <h1 class="text-6xl font-bold mb-6 leading-tight">
                        Découvrez des Séjours
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-rose-200 to-orange-200">
                            Exceptionnels
                        </span>
                    </h1>
                    <p class="text-xl mb-8 text-rose-100">
                        Des expériences uniques dans les plus beaux endroits du monde
                    </p>
                    <button class="bg-white text-rose-500 px-10 py-4 rounded-full text-lg font-semibold hover:bg-opacity-90 transition-all transform hover:-translate-y-1 shadow-lg">
                        Commencer l'aventure
                    </button>
                </div>
            </div>
        </div>

        <!-- Search Section avec animation au scroll -->
        <div class="container mx-auto px-4 relative z-20">
            <div class="glass-effect rounded-2xl shadow-2xl -mt-10 p-6 mx-auto max-w-4xl transform hover:-translate-y-1 transition-transform duration-300">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="relative">
                        <i data-feather="map-pin" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-rose-400"></i>
                        <input type="text" placeholder="Destination" class="w-full pl-10 pr-4 py-3 rounded-xl bg-white bg-opacity-50 focus:ring-2 focus:ring-rose-400 outline-none">
                    </div>
                    <div class="relative">
                        <i data-feather="calendar" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-rose-400"></i>
                        <input type="text" placeholder="Dates" class="w-full pl-10 pr-4 py-3 rounded-xl bg-white bg-opacity-50 focus:ring-2 focus:ring-rose-400 outline-none">
                    </div>
                    <button class="bg-gradient-to-r from-rose-500 to-orange-500 text-white py-3 px-6 rounded-xl hover:opacity-90 transition-all transform hover:-translate-y-1 shadow-lg">
                        Rechercher
                    </button>
                </div>
            </div>
        </div>

    <!-- Featured Listings -->
    <div class="container mx-auto px-4 py-20">
        <div class="flex justify-between items-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800">
                Destinations 
                <span class="text-rose-500">Populaires</span>
            </h2>
            <button class="text-rose-500 flex items-center hover:text-rose-600 transition-colors">
                <span>Voir tout</span>
                <i data-feather="arrow-right" class="ml-2 w-4 h-4"></i>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Property Card 1 -->
            <div class="group hover-scale">
                <div class="relative rounded-2xl overflow-hidden card-shadow bg-white">
                    <div class="absolute top-4 right-4 bg-white rounded-full p-2 shadow-lg z-10">
                        <i data-feather="heart" class="w-5 h-5 text-rose-500"></i>
                    </div>
                    <img src="/api/placeholder/400/300" alt="Villa luxueuse" class="w-full h-64 object-cover transition-transform group-hover:scale-110 duration-500">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Villa Vue Mer</h3>
                                <p class="text-gray-600 flex items-center">
                                    <i data-feather="map-pin" class="w-4 h-4 mr-1"></i>
                                    Nice, France
                                </p>
                            </div>
                            <span class="text-2xl font-bold text-rose-500">250€</span>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t">
                            <div class="flex items-center">
                                <i data-feather="star" class="text-yellow-400 w-4 h-4"></i>
                                <span class="ml-1 text-gray-600">4.9 (128)</span>
                            </div>
                            <button class="text-rose-500 font-semibold hover:text-rose-600">
                                Voir plus →
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Property Card 2 -->
            <div class="group hover-scale">
                <div class="relative rounded-2xl overflow-hidden card-shadow bg-white">
                    <div class="absolute top-4 right-4 bg-white rounded-full p-2 shadow-lg z-10">
                        <i data-feather="heart" class="w-5 h-5 text-rose-500"></i>
                    </div>
                    <img src="/api/placeholder/400/300" alt="Appartement moderne" class="w-full h-64 object-cover transition-transform group-hover:scale-110 duration-500">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Loft Design</h3>
                                <p class="text-gray-600 flex items-center">
                                    <i data-feather="map-pin" class="w-4 h-4 mr-1"></i>
                                    Paris, France
                                </p>
                            </div>
                            <span class="text-2xl font-bold text-rose-500">180€</span>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t">
                            <div class="flex items-center">
                                <i data-feather="star" class="text-yellow-400 w-4 h-4"></i>
                                <span class="ml-1 text-gray-600">4.7 (96)</span>
                            </div>
                            <button class="text-rose-500 font-semibold hover:text-rose-600">
                                Voir plus →
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Property Card 3 -->
            <div class="group hover-scale">
                <div class="relative rounded-2xl overflow-hidden card-shadow bg-white">
                    <div class="absolute top-4 right-4 bg-white rounded-full p-2 shadow-lg z-10">
                        <i data-feather="heart" class="w-5 h-5 text-rose-500"></i>
                    </div>
                    <img src="/api/placeholder/400/300" alt="Chalet luxueux" class="w-full h-64 object-cover transition-transform group-hover:scale-110 duration-500">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Chalet Premium</h3>
                                <p class="text-gray-600 flex items-center">
                                    <i data-feather="map-pin" class="w-4 h-4 mr-1"></i>
                                    Chamonix, France
                                </p>
                            </div>
                            <span class="text-2xl font-bold text-rose-500">320€</span>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t">
                            <div class="flex items-center">
                                <i data-feather="star" class="text-yellow-400 w-4 h-4"></i>
                                <span class="ml-1 text-gray-600">4.8 (156)</span>
                            </div>
                            <button class="text-rose-500 font-semibold hover:text-rose-600">
                                Voir plus →
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-rose-500 to-orange-500 opacity-90"></div>
        <div class="absolute inset-0 bg-[url('/api/placeholder/1920/400')] bg-cover bg-center mix-blend-overlay"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center text-white group hover-scale">
                    <div class="bg-white bg-opacity-20 rounded-2xl p-8 backdrop-blur-lg">
                        <i data-feather="home" class="w-12 h-12 mx-auto mb-6 transform group-hover:rotate-12 transition-transform"></i>
                        <div class="text-5xl font-bold mb-2">10k+</div>
                        <div class="text-lg opacity-90">Propriétés uniques</div>
                    </div>
                </div>
                <div class="text-center text-white group hover-scale">
                    <div class="bg-white bg-opacity-20 rounded-2xl p-8 backdrop-blur-lg">
                        <i data-feather="users" class="w-12 h-12 mx-auto mb-6 transform group-hover:rotate-12 transition-transform"></i>
                        <div class="text-5xl font-bold mb-2">50k+</div>
                        <div class="text-lg opacity-90">Clients satisfaits</div>
                    </div>
                </div>
                <div class="text-center text-white group hover-scale">
                    <div class="bg-white bg-opacity-20 rounded-2xl p-8 backdrop-blur-lg">
                        <i data-feather="star" class="w-12 h-12 mx-auto mb-6 transform group-hover:rotate-12 transition-transform"></i>
                        <div class="text-5xl font-bold mb-2">4.8</div>
                        <div class="text-lg opacity-90">Note moyenne</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
<footer class="bg-gradient-to-br from-rose-50 to-orange-50 border-t border-white border-opacity-20">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- About Section -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <i data-feather="home" class="w-8 h-8 text-rose-500"></i>
                    <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-rose-500 to-orange-500">
                        LuxStay
                    </span>
                </div>
                <p class="text-gray-600">
                    LuxStay propose des séjours uniques dans les plus beaux endroits du monde. Découvrez des expériences inoubliables.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-600 hover:text-rose-500 transition-colors">
                        <i data-feather="facebook" class="w-6 h-6"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-rose-500 transition-colors">
                        <i data-feather="twitter" class="w-6 h-6"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-rose-500 transition-colors">
                        <i data-feather="instagram" class="w-6 h-6"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-800">Liens Rapides</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-600 hover:text-rose-500 transition-colors">Accueil</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-rose-500 transition-colors">Destinations</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-rose-500 transition-colors">Offres</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-rose-500 transition-colors">À propos</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-rose-500 transition-colors">Contact</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-800">Contact</h3>
                <ul class="space-y-2">
                    <li class="text-gray-600 flex items-center">
                        <i data-feather="map-pin" class="w-4 h-4 mr-2 text-rose-500"></i>
                        123 Rue de Luxe, Paris, France
                    </li>
                    <li class="text-gray-600 flex items-center">
                        <i data-feather="phone" class="w-4 h-4 mr-2 text-rose-500"></i>
                        +33 1 23 45 67 89
                    </li>
                    <li class="text-gray-600 flex items-center">
                        <i data-feather="mail" class="w-4 h-4 mr-2 text-rose-500"></i>
                        contact@luxstay.com
                    </li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-800">Newsletter</h3>
                <p class="text-gray-600">
                    Abonnez-vous pour recevoir nos offres exclusives et les dernières actualités.
                </p>
                <form class="flex items-center">
                    <input type="email" placeholder="Votre email" class="w-full px-4 py-2 rounded-l-lg bg-white bg-opacity-50 focus:ring-2 focus:ring-rose-400 outline-none">
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-rose-500 to-orange-500 text-white rounded-r-lg hover:opacity-90 transition-opacity">
                        <i data-feather="send" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-white border-opacity-20 mt-8 pt-8 text-center text-gray-600">
            <p>&copy; 2023 LuxStay. Tous droits réservés.</p>
        </div>
    </div>
</footer>


    <script>
        feather.replace();
        
        // Simple scroll animation
        window.addEventListener('scroll', () => {
            const scrolled = window.scrollY;
            document.querySelectorAll('.hover-scale').forEach(element => {
                const position = element.getBoundingClientRect().top;
                if (position < window.innerHeight - 100) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        });
    </script>
</body>
</html>