<nav class="bg-black text-white py-4">
    <div class="container mx-auto px-6 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tighter">EULOZIA</a>
        <div class="hidden md:flex space-x-8">
            <a href="{{ route('products.index') }}" class="hover:text-accent transition-colors">SHOP ALL</a>
            <a href="#" class="hover:text-accent transition-colors">COLLECTIONS</a>
            <a href="#" class="hover:text-accent transition-colors">NEW ARRIVALS</a>
        </div>
        <div class="flex items-center space-x-6">
            <button class="hover:text-accent transition-colors"><i class="fas fa-search"></i></button>
            <button class="hover:text-accent transition-colors"><i class="fas fa-shopping-bag"></i></button>
            <a href="{{ route('account.index') }}" class="hover:text-accent transition-colors"><i class="fas fa-user"></i></a>
        </div>
    </div>
</nav>
