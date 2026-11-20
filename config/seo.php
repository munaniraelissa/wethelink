<?php

/*
|--------------------------------------------------------------------------
| SEO content
|--------------------------------------------------------------------------
| Site-wide defaults plus one entry per business sector. Each sector becomes
| an indexable landing page at /sectors/{slug} with its own title, meta
| description, intro text, FAQ (answering the long-tail / AI-style
| questions) and the products that match its "match" terms.
|
| Edit wording here freely; no code changes are needed.
*/

return [

    'site_name' => 'Wethelink',

    'default_title' => 'Wethelink – B2B Marketplace for Suppliers, Wholesalers & Manufacturers in Rwanda',

    'default_description' => 'Find trusted manufacturers, suppliers, wholesalers, importers and exporters across Rwanda, East Africa and Africa. Discover verified businesses, factory-direct products and wholesale prices on Wethelink.com, Rwanda\'s trusted B2B marketplace.',

    'default_keywords' => 'Trusted B2B Marketplace in Rwanda, Verified Suppliers Rwanda, Rwanda Wholesale Suppliers, Factory Price Products Rwanda, Direct Suppliers Rwanda, Rwanda Manufacturers Directory, Find Suppliers in Rwanda, Wholesale Products Rwanda, Buy Wholesale in Rwanda, Rwanda Retailers and Suppliers, Wholesale Prices Rwanda, Best B2B Platform Rwanda, Trusted B2B Marketplace East Africa, East Africa Wholesale Suppliers, B2B Trade Platform East Africa, Trusted African B2B Marketplace, African Wholesale Network, Verified African Suppliers, African Manufacturers Directory, Wholesale clothes in Rwanda, Electronics suppliers Rwanda, Electric motorcycles Rwanda, Construction materials Rwanda, Automotive spare parts Rwanda, Agricultural supplies Rwanda, Beauty products wholesale Rwanda, Food suppliers Rwanda, Industrial machinery Rwanda, Home products wholesale Rwanda, Office supplies Rwanda, Medical supplies Rwanda, Packaging materials Rwanda, Gorilla Textile Jeans, Rwanda Jeans Manufacturer',

    // Official profiles: tells Google these accounts belong to Wethelink.
    'social' => [
        'https://www.facebook.com/share/1azXLevQkf/',
        'https://x.com/wethelink_com',
        'https://www.linkedin.com/in/wethelink-group-454884415/',
        'https://www.instagram.com/wethelink_com',
        'https://www.tiktok.com/@wethelink_com',
    ],

    'sectors' => [

        'fashion-apparel' => [
            'name' => 'Fashion & Apparel',
            'icon' => 'fa fa-tshirt',
            'title' => 'Wholesale Clothes & Jeans Suppliers in Rwanda | Fashion & Apparel – Wethelink',
            'description' => 'Buy wholesale clothes in Rwanda. Find clothing manufacturers, jeans wholesalers in Kigali, denim and textile suppliers, and bulk fashion for retailers on Wethelink.',
            'heading' => 'Wholesale Clothing & Fashion Suppliers in Rwanda',
            'intro' => [
                'Wethelink connects retailers, boutiques and distributors with clothing manufacturers and wholesale fashion suppliers in Rwanda and across East Africa. Compare wholesale jeans, trousers, shirts, dresses, kids clothing and fashion accessories at factory and bulk prices.',
                'Every listing shows the minimum order quantity (MOQ), price in RWF and the supplier behind it, so you can contact Kigali clothing distributors and denim manufacturers directly and order in bulk.',
            ],
            'match' => ['jean', 'denim', 'cloth', 'fashion', 'apparel', 'textile', 'fabric', 'shirt', 'trouser', 'pantalo', 'dress', 'skirt', 'jacket', 'garment', 'wear'],
            'primary_keywords' => ['Wholesale clothes in Rwanda', 'Clothing suppliers in Rwanda', 'Wholesale fashion Rwanda', 'Jeans wholesalers in Rwanda', 'Clothing manufacturers Rwanda', 'Fashion products wholesale', 'Bulk clothing suppliers', 'Wholesale jeans Kigali', 'Affordable wholesale clothes', 'Fashion marketplace Rwanda'],
            'secondary_keywords' => ["Men's jeans wholesale Rwanda", "Women's jeans wholesale Rwanda", 'Kids clothing wholesale Rwanda', 'Denim suppliers in Rwanda', 'Wholesale trousers Rwanda', 'Wholesale shirts Rwanda', 'Wholesale dresses Rwanda', 'Fashion accessories wholesale', 'Clothing distributors Kigali', 'Textile suppliers Rwanda', 'Wholesale fashion accessories', 'Retail clothing suppliers Rwanda', 'Bulk denim suppliers', 'African fashion wholesale', 'Clothing importers Rwanda'],
            'faqs' => [
                'Where can I buy jeans wholesale in Rwanda?' => 'On Wethelink you can buy jeans wholesale directly from Rwandan denim manufacturers and Kigali wholesalers. Open the Fashion & Apparel sector, compare men\'s and women\'s jeans by price and minimum order quantity, then contact the supplier to place a bulk order.',
                'Where can retailers find affordable clothes in Kigali?' => 'Retailers can find affordable wholesale clothes from Kigali clothing distributors on Wethelink. Prices are listed in RWF with minimum order quantities, so you can compare suppliers before you buy.',
                'Which companies supply wholesale clothing in Rwanda?' => 'Wethelink lists clothing manufacturers, wholesalers and importers operating in Rwanda. Visit the Manufacturers page or the Fashion & Apparel sector to see each company and the clothing products it supplies.',
                'Where can I find reliable clothing manufacturers in Rwanda?' => 'Wethelink lists registered clothing and textile manufacturers in Rwanda with their company profile and products, so you can see who makes what and contact the factory directly.',
                'How can I find bulk fashion suppliers in East Africa?' => 'Use Wethelink to browse bulk fashion suppliers from Rwanda and East Africa. Filter by category, check minimum order quantities and message suppliers on WhatsApp straight from the product page.',
                'Where can I buy men\'s and women\'s jeans in bulk?' => 'Bulk men\'s and women\'s jeans are available from denim suppliers on Wethelink. Each product shows the MOQ and wholesale price so you can order the quantity your shop needs.',
                'What is the best B2B clothing marketplace in Rwanda?' => 'Wethelink is a Rwandan B2B marketplace built for wholesale buyers. It brings clothing manufacturers, wholesalers and retailers together with factory-direct prices and direct contact with each supplier.',
            ],
        ],

        'electronics-technology' => [
            'name' => 'Electronics & Technology',
            'icon' => 'fa fa-laptop',
            'title' => 'Wholesale Electronics Suppliers in Rwanda | Phones, Computers & Accessories – Wethelink',
            'description' => 'Find electronics wholesalers and technology suppliers in Kigali. Buy phone accessories, laptops, computer hardware, CCTV, LED and solar electronics in bulk on Wethelink.',
            'heading' => 'Wholesale Electronics & Technology Suppliers in Rwanda',
            'intro' => [
                'Source electronics in bulk from distributors and importers serving Rwanda and East Africa. Wethelink lists mobile phone and computer accessories, laptops, networking equipment, CCTV systems, LED lighting and solar electronics at wholesale prices.',
                'Compare suppliers in Kigali, including importers of Chinese electronics, check minimum order quantities and contact sellers directly to stock your shop or equip your business.',
            ],
            'match' => ['electronic', 'phone', 'laptop', 'computer', 'tablet', 'charger', 'cable', 'cctv', 'camera', 'led', 'solar', 'router', 'network', 'speaker', 'headphone', 'tv'],
            'primary_keywords' => ['Electronics suppliers Rwanda', 'Wholesale electronics Rwanda', 'Electronics marketplace Rwanda', 'Electronic products wholesale', 'Technology suppliers Kigali', 'Electronics distributors Rwanda', 'Bulk electronics suppliers', 'Chinese electronics suppliers Rwanda'],
            'secondary_keywords' => ['Mobile phone accessories wholesale', 'Computer accessories suppliers Rwanda', 'Laptop wholesalers Rwanda', 'Smartphone accessories wholesale', 'LED lighting suppliers Rwanda', 'Solar electronics suppliers Rwanda', 'Home electronics wholesale', 'Networking equipment suppliers', 'Computer hardware wholesale', 'CCTV equipment suppliers Rwanda', 'Electrical gadgets wholesale', 'Electronic components suppliers', 'Technology products wholesale', 'Electronics importers Rwanda'],
            'faqs' => [
                'Where can I find electronics wholesalers in Rwanda?' => 'Wethelink lists electronics wholesalers, distributors and importers in Rwanda. Open the Electronics & Technology sector to compare products, wholesale prices and minimum order quantities.',
                'Where can retailers buy phone accessories in bulk?' => 'Retailers can buy chargers, cables, cases and other smartphone accessories in bulk from suppliers on Wethelink and contact them directly to order.',
                'How can I find reliable Chinese electronics suppliers for Rwanda?' => 'Many electronics importers on Wethelink source from China and sell in Rwanda. Check each supplier\'s company profile and products, then contact them to confirm stock, warranty and delivery.',
                'Which companies supply computers and electronic equipment in Kigali?' => 'Kigali technology suppliers on Wethelink offer laptops, computer hardware, networking and CCTV equipment. Browse the sector page to see each company and its products.',
                'Where can businesses source affordable electronics in East Africa?' => 'Businesses can source affordable electronics at wholesale prices from Rwandan and East African distributors on Wethelink, comparing several suppliers in one place.',
            ],
        ],

        'electric-mobility' => [
            'name' => 'Electric Mobility',
            'icon' => 'fa fa-motorcycle',
            'title' => 'Electric Motorcycles & Scooters in Rwanda | E-Mobility Suppliers – Wethelink',
            'description' => 'Buy electric motorcycles, electric scooters, e-bikes and tricycles in Rwanda. Find electric vehicle suppliers, batteries and spare parts in Kigali on Wethelink.',
            'heading' => 'Electric Motorcycles, Scooters & E-Mobility in Rwanda',
            'intro' => [
                'Rwanda is moving fast to electric transport. Wethelink connects riders, delivery companies and dealers with suppliers of electric motorcycles, electric scooters, e-bikes and electric tricycles, including long-range lithium battery models.',
                'Find electric scooter distributors in Kigali, electric motorcycle importers, batteries, spare parts and accessories, and contact suppliers directly for single units or bulk fleet orders.',
            ],
            'match' => ['electric', 'scooter', 'e-bike', 'ebike', 'motorcycle', 'moto', 'tricycle', 'lithium', 'battery', 'ev '],
            'primary_keywords' => ['Electric scooters Rwanda', 'Electric motorcycles Rwanda', 'Electric vehicles Rwanda', 'Electric mobility Rwanda', 'Electric transport Rwanda', 'Electric bikes wholesale', 'Electric scooter suppliers Rwanda', 'Electric motorcycle suppliers', 'Chinese electric scooters Rwanda', 'Electric vehicle marketplace Rwanda'],
            'secondary_keywords' => ['Lithium battery electric scooters', 'Long-range electric motorcycles', 'Electric bikes wholesale Rwanda', 'Electric scooter distributors Kigali', 'Electric motorcycle importers Rwanda', 'Electric mobility solutions Africa', 'Electric vehicle accessories', 'Electric scooter spare parts', 'Electric motorcycle batteries', 'Affordable electric motorcycles', 'Urban electric transport Rwanda', 'Electric mobility suppliers East Africa', 'Electric tricycles Rwanda', 'Electric delivery motorcycles'],
            'faqs' => [
                'Where can I buy electric motorcycles in Rwanda?' => 'You can buy electric motorcycles from suppliers and importers listed on Wethelink. Open the Electric Mobility sector to compare models and prices, and contact the seller directly.',
                'Where can I find Chinese electric scooter suppliers?' => 'Several electric scooter importers on Wethelink source models from China for the Rwandan market. Check their products and company profile, then ask about range, battery and warranty.',
                'What electric motorcycles are available in Rwanda?' => 'Wethelink shows the electric motorcycles that suppliers currently list in Rwanda, including long-range lithium battery and delivery models. The sector page is updated as suppliers add products.',
                'Where can businesses source electric bikes in bulk?' => 'Delivery and transport businesses can source electric bikes and motorcycles in bulk from distributors on Wethelink. Each listing shows the minimum order quantity.',
                'Which suppliers sell long-range electric scooters in East Africa?' => 'Browse the Electric Mobility sector on Wethelink to find suppliers of long-range electric scooters and motorcycles serving Rwanda and East Africa.',
                'Where can I find electric mobility products for my business in Rwanda?' => 'Wethelink brings together electric vehicles, batteries, spare parts and accessories from Rwandan suppliers, so businesses can source everything for an electric fleet in one place.',
            ],
        ],

        'construction-materials' => [
            'name' => 'Construction Materials',
            'icon' => 'fa fa-hard-hat',
            'title' => 'Construction & Building Materials Suppliers in Rwanda | Cement, Steel, Roofing – Wethelink',
            'description' => 'Buy construction materials in Rwanda at wholesale prices. Find cement, steel, iron sheets, tiles, PVC pipes, paint and roofing suppliers in Kigali on Wethelink.',
            'heading' => 'Construction & Building Materials Suppliers in Rwanda',
            'intro' => [
                'Contractors, developers and hardware shops use Wethelink to source building materials in bulk. Find suppliers of cement, steel and reinforcement bars, roofing and iron sheets, tiles, PVC pipes, plumbing and electrical materials, paint, aluminium, doors and windows.',
                'Compare construction material distributors and importers in Kigali and across Rwanda, including suppliers of materials from China, and contact them directly for quotes on large orders.',
            ],
            'match' => ['cement', 'steel', 'iron', 'roof', 'tile', 'pipe', 'pvc', 'plumb', 'paint', 'aluminium', 'aluminum', 'door', 'window', 'brick', 'sand', 'gravel', 'construction', 'building', 'hardware'],
            'primary_keywords' => ['Construction materials Rwanda', 'Building materials suppliers Rwanda', 'Wholesale construction materials', 'Construction supplies Kigali', 'Building materials wholesale Rwanda', 'Construction marketplace Rwanda', 'Bulk building materials', 'Construction material distributors Rwanda'],
            'secondary_keywords' => ['Cement suppliers Rwanda', 'Steel suppliers Rwanda', 'Roofing materials Rwanda', 'Tiles wholesalers Rwanda', 'Plumbing materials suppliers', 'Electrical construction materials', 'Construction equipment materials', 'Sand and gravel suppliers Rwanda', 'Building hardware wholesale', 'PVC pipes suppliers Rwanda', 'Aluminium suppliers Rwanda', 'Doors and windows suppliers', 'Paint suppliers Rwanda', 'Waterproofing materials wholesale', 'Iron sheets wholesale Rwanda', 'Reinforcement bars suppliers Rwanda', 'Chinese construction materials suppliers', 'Building material importers Rwanda'],
            'faqs' => [
                'Where can contractors buy construction materials in Rwanda?' => 'Contractors can buy construction materials from suppliers across Rwanda on Wethelink, from cement and steel to roofing, tiles and plumbing, and request bulk quotes directly.',
                'Where can I find wholesale building materials in Kigali?' => 'The Construction Materials sector on Wethelink lists Kigali building material wholesalers and distributors with their products, prices and minimum order quantities.',
                'Who supplies affordable roofing materials in Rwanda?' => 'Roofing and iron sheet suppliers list their products on Wethelink. Compare prices from several suppliers before ordering.',
                'Where can construction companies find reliable suppliers?' => 'Wethelink shows each supplier\'s company profile alongside its products, so construction companies can check who they are buying from and contact them directly.',
                'How can I source building materials from China to Rwanda?' => 'Building material importers on Wethelink bring products from China to Rwanda. Contact them through the platform to ask about available stock, lead times and bulk pricing.',
                'Where can I buy cement, steel and tiles in bulk in Rwanda?' => 'You can buy cement, steel and tiles in bulk from Rwandan construction suppliers on Wethelink and compare offers in one place.',
            ],
        ],

        'automotive-spare-parts' => [
            'name' => 'Automotive & Spare Parts',
            'icon' => 'fa fa-cogs',
            'title' => 'Car & Truck Spare Parts Suppliers in Rwanda | Sinotruk, Shacman Parts – Wethelink',
            'description' => 'Find genuine car and truck spare parts in Rwanda. Wholesale auto parts, Sinotruk and Shacman spare parts, engine, brake and suspension parts from Kigali suppliers on Wethelink.',
            'heading' => 'Automotive & Truck Spare Parts Suppliers in Rwanda',
            'intro' => [
                'Garages, transport companies and parts shops use Wethelink to source vehicle parts in bulk. Find car, bus, motorcycle and heavy truck spare parts, including Sinotruk and Shacman parts, engine and diesel components, brakes, suspension, filters and batteries.',
                'Compare automotive suppliers and importers in Kigali and East Africa and contact them directly for genuine parts at wholesale prices.',
            ],
            'match' => ['spare', 'part', 'auto', 'car ', 'truck', 'sinotruk', 'shacman', 'engine', 'brake', 'filter', 'tyre', 'tire', 'suspension', 'vehicle', 'diesel'],
            'primary_keywords' => ['Automotive spare parts Rwanda', 'Car spare parts suppliers Rwanda', 'Wholesale auto parts Rwanda', 'Truck spare parts Rwanda', 'Automotive suppliers Kigali', 'Genuine spare parts Rwanda', 'Auto parts marketplace Rwanda', 'Chinese truck spare parts', 'Vehicle parts wholesalers Rwanda'],
            'secondary_keywords' => ['Sinotruk spare parts Rwanda', 'Shacman spare parts Rwanda', 'Heavy truck spare parts', 'Engine parts suppliers Rwanda', 'Brake parts wholesale', 'Suspension parts suppliers', 'Vehicle batteries wholesale', 'Truck filters suppliers', 'Automotive accessories wholesale', 'Motorcycle spare parts Rwanda', 'Car engine components', 'Bus spare parts suppliers', 'Commercial vehicle parts', 'Automotive importers Rwanda', 'Diesel engine spare parts', 'Genuine truck components', 'Auto parts distributors East Africa'],
            'faqs' => [
                'Where can I buy genuine truck spare parts in Rwanda?' => 'Truck spare part suppliers on Wethelink sell genuine parts for heavy trucks in Rwanda. Open the Automotive & Spare Parts sector and contact the supplier to confirm part numbers.',
                'Where can I find Sinotruk and Shacman spare parts?' => 'Suppliers on Wethelink list Sinotruk and Shacman spare parts for the Rwandan market, including engine, brake, suspension and filter components.',
                'Which companies supply automotive parts in Kigali?' => 'Browse the sector page or the Manufacturers page on Wethelink to see Kigali automotive suppliers and the parts each one sells.',
                'Where can garages source vehicle spare parts in bulk?' => 'Garages can source car, bus and truck parts in bulk from wholesalers on Wethelink, with minimum order quantities shown on every product.',
                'How can I find reliable Chinese automotive suppliers?' => 'Automotive importers on Wethelink bring parts from Chinese manufacturers to Rwanda. Check the company profile and contact them about authenticity and warranty.',
                'Where can transport companies buy truck parts in Rwanda?' => 'Transport and logistics companies can buy commercial vehicle and truck parts from Rwandan suppliers on Wethelink and order directly.',
            ],
        ],

        'agriculture-farming' => [
            'name' => 'Agriculture & Farming',
            'icon' => 'fa fa-seedling',
            'title' => 'Agricultural Supplies & Farming Equipment in Rwanda | Irrigation, Seeds, Fertilizer – Wethelink',
            'description' => 'Find agricultural suppliers in Rwanda: farm machinery, irrigation equipment, seeds, fertilizer, animal feed, poultry and greenhouse supplies from Kigali suppliers on Wethelink.',
            'heading' => 'Agricultural Supplies & Farming Equipment in Rwanda',
            'intro' => [
                'Farmers, cooperatives and agribusinesses use Wethelink to find agricultural suppliers in Rwanda. Source farm machinery and tractor parts, irrigation systems, greenhouse materials, sprayers, farm tools, seeds, fertilizer, animal feed and poultry and livestock equipment.',
                'Compare agricultural equipment suppliers in Kigali and importers of farming machinery, and contact them directly for wholesale and bulk orders.',
            ],
            'match' => ['agri', 'farm', 'seed', 'fertili', 'irrigat', 'tractor', 'greenhouse', 'poultry', 'livestock', 'feed', 'sprayer', 'harvest', 'hoe'],
            'primary_keywords' => ['Agricultural supplies Rwanda', 'Farming equipment Rwanda', 'Agricultural products wholesale', 'Agriculture suppliers Rwanda', 'Farm machinery suppliers', 'Agricultural marketplace Rwanda', 'Farming tools wholesale', 'Agricultural equipment Kigali'],
            'secondary_keywords' => ['Irrigation equipment Rwanda', 'Agricultural machinery wholesale', 'Greenhouse materials suppliers', 'Farm tools suppliers Rwanda', 'Poultry farming equipment', 'Livestock farming supplies', 'Fertilizer suppliers Rwanda', 'Seeds suppliers Rwanda', 'Animal feed wholesale', 'Sprayers and farming equipment', 'Tractor spare parts Rwanda', 'Post-harvest equipment', 'Agricultural technology Rwanda', 'Irrigation systems suppliers', 'Farming accessories wholesale', 'Agricultural importers Rwanda'],
            'faqs' => [
                'Where can farmers buy agricultural equipment in Rwanda?' => 'Farmers can buy agricultural equipment, tools and machinery from suppliers across Rwanda on Wethelink and contact sellers directly.',
                'Where can I find wholesale farming supplies in Kigali?' => 'The Agriculture & Farming sector on Wethelink lists Kigali suppliers of seeds, fertilizer, animal feed and farm tools at wholesale prices.',
                'Which companies supply irrigation equipment in Rwanda?' => 'Irrigation equipment suppliers list their systems and parts on Wethelink. Browse the sector page to compare them.',
                'Where can agricultural businesses find reliable suppliers?' => 'Wethelink shows a company profile for every supplier, so cooperatives and agribusinesses can see who they are dealing with before ordering.',
                'How can I source farming machinery from China to Rwanda?' => 'Agricultural importers on Wethelink bring farm machinery from China. Contact them to ask about models, spare parts and delivery to Rwanda.',
            ],
        ],

        'beauty-personal-care' => [
            'name' => 'Beauty & Personal Care',
            'icon' => 'fa fa-spa',
            'title' => 'Wholesale Cosmetics & Beauty Products in Rwanda | Skincare, Hair, Salon Supplies – Wethelink',
            'description' => 'Buy beauty products wholesale in Rwanda. Find cosmetics wholesalers in Kigali, skincare, hair care, hair extensions, perfume and salon and barber supplies on Wethelink.',
            'heading' => 'Wholesale Beauty & Personal Care Products in Rwanda',
            'intro' => [
                'Beauty shops, salons and pharmacies use Wethelink to buy cosmetics in bulk. Find suppliers of skincare, makeup, hair care products, hair extensions, perfume, nail products, personal hygiene products, and salon and barber equipment.',
                'Compare cosmetics wholesalers and beauty distributors in Kigali and East Africa, including importers, and contact them directly for wholesale prices.',
            ],
            'match' => ['beauty', 'cosmetic', 'skin', 'hair', 'makeup', 'perfume', 'nail', 'salon', 'barber', 'lotion', 'soap', 'cream', 'hygiene'],
            'primary_keywords' => ['Beauty products wholesale Rwanda', 'Cosmetics suppliers Rwanda', 'Beauty products marketplace Rwanda', 'Personal care products wholesale', 'Cosmetics wholesalers Kigali', 'Beauty supply distributors Rwanda', 'Bulk beauty products', 'Skincare products suppliers Rwanda'],
            'secondary_keywords' => ['Hair care products wholesale', 'Hair extensions suppliers Rwanda', 'Beauty salon supplies wholesale', 'Makeup products wholesale', 'Skincare distributors Rwanda', 'Perfume suppliers Rwanda', 'Beauty accessories wholesale', 'Nail products suppliers', 'Barber supplies wholesale', 'Hairdressing equipment suppliers', 'Personal hygiene products wholesale', 'Cosmetic importers Rwanda', 'Beauty products distributors East Africa'],
            'faqs' => [
                'Where can I buy cosmetics wholesale in Rwanda?' => 'You can buy cosmetics wholesale from beauty distributors and importers on Wethelink. Compare prices and minimum order quantities in the Beauty & Personal Care sector.',
                'Where can beauty shops find affordable suppliers in Kigali?' => 'Beauty shops can find affordable cosmetics wholesalers in Kigali on Wethelink and contact them directly through WhatsApp or the company profile.',
                'Who supplies skincare and hair products in Rwanda?' => 'Skincare and hair care suppliers in Rwanda list their products on Wethelink. Browse the sector page to see each supplier.',
                'Where can I find wholesale salon equipment?' => 'Salon, hairdressing and barber equipment suppliers are listed in the Beauty & Personal Care sector on Wethelink.',
                'How can retailers source beauty products from China?' => 'Cosmetic importers on Wethelink bring beauty products from China and other countries to Rwanda, so retailers can buy locally without importing themselves.',
            ],
        ],

        'food-beverages' => [
            'name' => 'Food & Beverages',
            'icon' => 'fa fa-utensils',
            'title' => 'Wholesale Food & Beverage Suppliers in Rwanda | Rice, Cooking Oil, Coffee, Tea – Wethelink',
            'description' => 'Find food suppliers and beverage distributors in Rwanda. Buy rice, sugar, flour, cooking oil, Rwandan coffee and tea, drinks and packaged food wholesale in Kigali on Wethelink.',
            'heading' => 'Wholesale Food & Beverage Suppliers in Rwanda',
            'intro' => [
                'Supermarkets, shops, restaurants and hotels use Wethelink to source food and drinks in bulk. Find wholesalers of rice, sugar, flour and cooking oil, packaged food and snacks, beverages and mineral water, and food ingredients.',
                'Buyers looking to export can also find suppliers of Rwandan coffee and tea. Compare food distributors in Kigali and across East Africa and contact them directly.',
            ],
            'match' => ['food', 'rice', 'sugar', 'flour', 'oil', 'coffee', 'tea', 'water', 'juice', 'drink', 'beverage', 'snack', 'milk', 'bean', 'maize'],
            'primary_keywords' => ['Food suppliers Rwanda', 'Wholesale food products Rwanda', 'Food distributors Kigali', 'Food and beverages wholesale', 'Food marketplace Rwanda', 'Bulk food suppliers Rwanda', 'Beverage suppliers Rwanda', 'Food wholesalers East Africa'],
            'secondary_keywords' => ['Coffee suppliers Rwanda', 'Tea suppliers Rwanda', 'Rice wholesalers Rwanda', 'Cooking oil suppliers Rwanda', 'Sugar wholesalers Rwanda', 'Flour suppliers Rwanda', 'Packaged food distributors', 'Restaurant food suppliers Rwanda', 'Wholesale beverages Kigali', 'Mineral water distributors Rwanda', 'Food ingredients wholesale', 'Agricultural food products Rwanda', 'Food processing supplies', 'Food importers Rwanda', 'Wholesale snacks suppliers'],
            'faqs' => [
                'Where can supermarkets find food suppliers in Rwanda?' => 'Supermarkets can find food wholesalers and distributors across Rwanda on Wethelink and compare prices and minimum order quantities in one place.',
                'Where can restaurants buy food products in bulk?' => 'Restaurants and hotels can buy food products and ingredients in bulk from suppliers listed in the Food & Beverages sector on Wethelink.',
                'Which companies distribute beverages in Kigali?' => 'Beverage and mineral water distributors in Kigali list their products on Wethelink. Browse the sector page to contact them.',
                'Where can retailers find wholesale rice and cooking oil?' => 'Retailers can find wholesale rice, cooking oil, sugar and flour from Rwandan food wholesalers on Wethelink.',
                'How can businesses find reliable food suppliers in Rwanda?' => 'Wethelink shows a company profile with every food product, so businesses can check each supplier and contact them directly before ordering.',
                'Where can I source Rwandan coffee and tea for export?' => 'Suppliers of Rwandan coffee and tea list their products on Wethelink. Contact them directly about export quantities and grades.',
            ],
        ],

        'industrial-machinery' => [
            'name' => 'Industrial Machinery & Equipment',
            'icon' => 'fa fa-industry',
            'title' => 'Industrial Machinery & Equipment Suppliers in Rwanda | Generators, Excavators – Wethelink',
            'description' => 'Find industrial machinery suppliers in Rwanda: excavators, generators, welding machines, compressors, pumps, CNC and packaging machines from Kigali suppliers on Wethelink.',
            'heading' => 'Industrial Machinery & Equipment Suppliers in Rwanda',
            'intro' => [
                'Factories, construction firms and mining companies use Wethelink to source machinery. Find suppliers of excavators and heavy construction machinery, industrial generators, welding machines, air compressors, industrial pumps, CNC machines, and packaging and production equipment.',
                'Compare heavy equipment importers and industrial distributors in Kigali, including suppliers of Chinese machinery, and get spare parts and industrial tools from the same marketplace.',
            ],
            'match' => ['machine', 'machinery', 'generator', 'excavator', 'welding', 'compressor', 'pump', 'cnc', 'industrial', 'equipment', 'mining', 'factory'],
            'primary_keywords' => ['Industrial machinery Rwanda', 'Industrial equipment suppliers Rwanda', 'Factory equipment wholesale', 'Industrial machinery marketplace', 'Manufacturing equipment Rwanda', 'Industrial suppliers Kigali', 'Heavy machinery suppliers Rwanda', 'Industrial equipment distributors'],
            'secondary_keywords' => ['Excavators suppliers Rwanda', 'Construction machinery wholesale', 'Manufacturing machines suppliers', 'Industrial generators Rwanda', 'Welding machines wholesale', 'Packaging machinery suppliers', 'Agricultural industrial machinery', 'Factory production equipment', 'CNC machines suppliers', 'Industrial pumps suppliers', 'Air compressors wholesale', 'Mining equipment suppliers Rwanda', 'Industrial tools wholesale', 'Chinese machinery suppliers Rwanda', 'Heavy equipment importers Rwanda', 'Industrial spare parts suppliers'],
            'faqs' => [
                'Where can businesses buy industrial machinery in Rwanda?' => 'Businesses can buy industrial machinery from suppliers and importers across Rwanda on Wethelink and contact them directly for quotes.',
                'Where can I find Chinese excavator suppliers for Rwanda?' => 'Heavy equipment importers on Wethelink supply excavators and construction machinery from Chinese manufacturers to Rwanda.',
                'Which companies supply factory equipment in Kigali?' => 'The Industrial Machinery sector on Wethelink lists Kigali suppliers of factory, production and packaging equipment.',
                'Where can manufacturers source production machinery?' => 'Manufacturers can source production, CNC and packaging machines from industrial suppliers on Wethelink, along with spare parts.',
                'How can I import industrial equipment from China to Rwanda?' => 'Instead of importing yourself, you can contact machinery importers on Wethelink who already bring industrial equipment from China, and ask about models, lead times and after-sales service.',
                'Where can construction companies find heavy machinery suppliers?' => 'Construction companies can find excavators, generators and other heavy machinery suppliers in Rwanda on Wethelink.',
            ],
        ],

        'home-living' => [
            'name' => 'Home & Living',
            'icon' => 'fa fa-couch',
            'title' => 'Wholesale Home Products & Furniture Suppliers in Rwanda | Kitchenware, Decor – Wethelink',
            'description' => 'Buy household products wholesale in Rwanda. Find furniture wholesalers, kitchenware, home decoration, appliances, lighting, curtains and carpets suppliers in Kigali on Wethelink.',
            'heading' => 'Wholesale Home & Living Products in Rwanda',
            'intro' => [
                'Furniture shops, hotels and household goods retailers use Wethelink to buy in bulk. Find suppliers of furniture for bedrooms and living rooms, kitchenware, household appliances, home decoration, lighting, bathroom accessories, storage, cleaning supplies, curtains and carpets.',
                'Compare household goods distributors in Kigali and furniture importers, including suppliers of home products from China, and contact them directly.',
            ],
            'match' => ['furniture', 'sofa', 'bed', 'chair', 'table', 'kitchen', 'household', 'home', 'decor', 'curtain', 'carpet', 'mattress', 'appliance', 'cleaning'],
            'primary_keywords' => ['Home products wholesale Rwanda', 'Home supplies Rwanda', 'Household products wholesale', 'Home furniture suppliers Rwanda', 'Home and living marketplace Rwanda', 'Household goods distributors Kigali', 'Home accessories wholesale', 'Furniture wholesalers Rwanda'],
            'secondary_keywords' => ['Kitchenware wholesale Rwanda', 'Home decoration suppliers', 'Household appliances wholesale', 'Bedroom furniture suppliers', 'Living room furniture wholesale', 'Home improvement products Rwanda', 'Bathroom accessories suppliers', 'Lighting products wholesale', 'Storage products wholesale', 'Home cleaning supplies', 'Curtains and carpets wholesale', 'Interior decoration products', 'Furniture importers Rwanda', 'Chinese home products suppliers'],
            'faqs' => [
                'Where can I buy household products wholesale in Rwanda?' => 'You can buy household products wholesale from distributors listed in the Home & Living sector on Wethelink.',
                'Where can furniture shops find reliable suppliers in Kigali?' => 'Furniture wholesalers and importers in Kigali list their products and company profiles on Wethelink, so shops can compare and contact them directly.',
                'Where can retailers source kitchenware in bulk?' => 'Retailers can source kitchenware and household appliances in bulk from suppliers on Wethelink, with minimum order quantities shown on each product.',
                'Who supplies home decoration products in Rwanda?' => 'Home decoration, lighting and interior products suppliers in Rwanda are listed in the Home & Living sector on Wethelink.',
                'How can I find affordable home products from China?' => 'Importers on Wethelink bring affordable home products from China to Rwanda, so you can buy locally at wholesale prices.',
            ],
        ],

        'office-stationery' => [
            'name' => 'Office & Stationery',
            'icon' => 'fa fa-pencil-alt',
            'title' => 'Office Supplies & Stationery Wholesalers in Rwanda | School Supplies – Wethelink',
            'description' => 'Find office supplies and stationery wholesalers in Rwanda. Buy notebooks, pens, printing paper, school supplies, office furniture, printers and office equipment in Kigali on Wethelink.',
            'heading' => 'Office Supplies & Stationery Wholesalers in Rwanda',
            'intro' => [
                'Schools, offices and stationery shops use Wethelink to buy supplies in bulk. Find wholesalers of notebooks, pens and pencils, printing paper, school and educational materials, office furniture and chairs, printers, scanners and office electronics.',
                'Compare office equipment suppliers and importers in Kigali and contact them directly for corporate and school orders.',
            ],
            'match' => ['office', 'stationery', 'paper', 'notebook', 'pen', 'pencil', 'printer', 'scanner', 'school', 'book', 'ink', 'toner'],
            'primary_keywords' => ['Office supplies Rwanda', 'Stationery wholesalers Rwanda', 'Office products wholesale', 'Office equipment suppliers Kigali', 'Stationery suppliers Rwanda', 'Office supplies marketplace Rwanda', 'Bulk stationery suppliers', 'Business equipment wholesale'],
            'secondary_keywords' => ['School stationery wholesale', 'Printing paper suppliers Rwanda', 'Office furniture suppliers', 'Office chairs wholesale', 'Printers and scanners suppliers', 'Office electronics wholesale', 'School supplies distributors', 'Notebooks wholesale Rwanda', 'Pens and pencils wholesale', 'Office storage supplies', 'Computer office accessories', 'Corporate office supplies', 'Educational materials wholesale', 'Office equipment importers Rwanda'],
            'faqs' => [
                'Where can schools buy stationery wholesale in Rwanda?' => 'Schools can buy notebooks, pens and other stationery wholesale from suppliers in the Office & Stationery sector on Wethelink.',
                'Where can businesses find affordable office supplies in Kigali?' => 'Businesses can compare office supplies wholesalers in Kigali on Wethelink and contact them directly for corporate orders.',
                'Who supplies office furniture in Rwanda?' => 'Office furniture and chair suppliers in Rwanda list their products on Wethelink.',
                'Where can retailers buy notebooks and school materials in bulk?' => 'Stationery shops can buy notebooks and school materials in bulk from distributors on Wethelink, with minimum order quantities on each listing.',
                'Which companies supply office equipment in Rwanda?' => 'Office equipment suppliers and importers offering printers, scanners and office electronics are listed in the Office & Stationery sector on Wethelink.',
            ],
        ],

        'health-medical-supplies' => [
            'name' => 'Health & Medical Supplies',
            'icon' => 'fa fa-briefcase-medical',
            'title' => 'Medical Supplies & Equipment Suppliers in Rwanda | Hospital, Lab, Clinic – Wethelink',
            'description' => 'Find medical equipment suppliers in Rwanda: hospital beds, laboratory and diagnostic equipment, gloves, PPE, surgical instruments and clinic consumables in Kigali on Wethelink.',
            'heading' => 'Medical Supplies & Equipment Suppliers in Rwanda',
            'intro' => [
                'Hospitals, clinics, pharmacies and laboratories use Wethelink to find healthcare suppliers. Source hospital beds and medical furniture, laboratory and diagnostic equipment, surgical and dental instruments, medical gloves and protective equipment, first aid supplies and hospital consumables.',
                'Compare medical equipment distributors and importers in Kigali and contact them directly about certification, stock and bulk pricing.',
            ],
            'match' => ['medical', 'hospital', 'clinic', 'lab', 'diagnostic', 'surgical', 'glove', 'mask', 'ppe', 'dental', 'first aid', 'syringe', 'health'],
            'primary_keywords' => ['Medical supplies Rwanda', 'Medical equipment suppliers Rwanda', 'Healthcare supplies wholesale', 'Medical products distributors Rwanda', 'Hospital equipment suppliers Kigali', 'Medical marketplace Rwanda', 'Healthcare equipment Rwanda', 'Medical consumables suppliers'],
            'secondary_keywords' => ['Hospital beds suppliers Rwanda', 'Medical furniture wholesale', 'Laboratory equipment suppliers', 'Diagnostic equipment Rwanda', 'Medical protective equipment', 'Surgical instruments suppliers', 'Medical gloves wholesale', 'Hospital consumables Rwanda', 'Healthcare technology suppliers', 'First aid equipment wholesale', 'Dental equipment suppliers Rwanda', 'Medical devices distributors', 'Medical equipment importers Rwanda', 'Clinic supplies wholesale'],
            'faqs' => [
                'Where can hospitals buy medical equipment in Rwanda?' => 'Hospitals can find medical equipment suppliers and importers in Rwanda on Wethelink and contact them directly for quotes and product documentation.',
                'Where can clinics find reliable medical suppliers in Kigali?' => 'Clinics can browse Kigali medical suppliers in the Health & Medical Supplies sector on Wethelink and review each company profile before ordering.',
                'Who supplies laboratory equipment in Rwanda?' => 'Laboratory and diagnostic equipment suppliers list their products on Wethelink.',
                'Where can healthcare businesses source medical consumables?' => 'Healthcare businesses can source gloves, protective equipment and other consumables in bulk from distributors on Wethelink.',
                'How can medical equipment distributors find wholesale suppliers?' => 'Distributors can use Wethelink to find manufacturers and importers of medical devices and supplies, and to list their own products for hospitals and clinics.',
            ],
        ],

        'packaging-printing' => [
            'name' => 'Packaging & Printing',
            'icon' => 'fa fa-box-open',
            'title' => 'Packaging Materials & Printing Suppliers in Rwanda | Boxes, Bags, Labels – Wethelink',
            'description' => 'Find packaging suppliers in Rwanda: cardboard and carton boxes, plastic and paper packaging, food packaging, bags, labels, printing paper and printing machines in Kigali on Wethelink.',
            'heading' => 'Packaging Materials & Printing Suppliers in Rwanda',
            'intro' => [
                'Manufacturers, food businesses and retailers use Wethelink to source packaging in bulk. Find suppliers of cardboard and carton boxes, plastic and paper packaging, food packaging, bottles, packaging bags, labels and stickers, and custom packaging.',
                'Printing companies can also find printing paper, printing machines and packaging machinery. Compare packaging distributors and importers in Kigali and contact them directly.',
            ],
            'match' => ['packag', 'box', 'carton', 'cardboard', 'bag', 'label', 'sticker', 'print', 'bottle', 'wrap'],
            'primary_keywords' => ['Packaging materials Rwanda', 'Packaging suppliers Rwanda', 'Printing supplies wholesale', 'Packaging products wholesale', 'Packaging marketplace Rwanda', 'Printing companies suppliers Kigali', 'Bulk packaging materials', 'Packaging distributors Rwanda'],
            'secondary_keywords' => ['Plastic packaging suppliers Rwanda', 'Paper packaging wholesale', 'Cardboard boxes suppliers', 'Food packaging materials Rwanda', 'Product packaging suppliers', 'Packaging bags wholesale', 'Labels and stickers suppliers', 'Printing machines Rwanda', 'Printing paper wholesale', 'Packaging machinery suppliers', 'Custom packaging suppliers Rwanda', 'Industrial packaging materials', 'Bottle packaging suppliers', 'Carton box manufacturers Rwanda', 'Printing equipment distributors', 'Packaging importers Rwanda'],
            'faqs' => [
                'Where can businesses buy packaging materials in Rwanda?' => 'Businesses can buy packaging materials from suppliers across Rwanda in the Packaging & Printing sector on Wethelink.',
                'Where can manufacturers find wholesale packaging suppliers?' => 'Manufacturers can compare wholesale packaging suppliers and carton box manufacturers on Wethelink and contact them directly for bulk orders.',
                'Who supplies cardboard boxes in Kigali?' => 'Cardboard and carton box suppliers in Kigali list their products on Wethelink.',
                'Where can retailers buy product packaging in bulk?' => 'Retailers can buy bags, boxes, labels and product packaging in bulk from distributors on Wethelink.',
                'Where can food businesses find packaging suppliers in Rwanda?' => 'Food businesses can find food packaging and bottle suppliers in Rwanda on Wethelink.',
                'How can companies source packaging materials from China?' => 'Packaging importers on Wethelink bring materials and machinery from China to Rwanda, so companies can buy locally without importing themselves.',
            ],
        ],
    ],
];
