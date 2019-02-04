<?php

use Illuminate\Database\Seeder;
use App\Models\Make;

class MakeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $makes = [
            [
                'name' => 'Aprilia',
                'description' => 'Aprilia is an Italian motorcycle company, one of the brands owned by Piaggio. Having started as a manufacturer of bicycles it moved on to manufacture scooters and small-capacity motorcycles. In more recent times Aprilia has produced large sportbikes such as the 1,000 cc V-twin RSV Mille and the V4 RSV4. Aprilia has enjoyed considerable success in road-racing.',
                'active' => 1
            ],
            [
                'name' => 'Bajaj',
                'description' => 'Bajaj Auto Limited is a global two-wheeler and three-wheeler manufacturing company based in India. It manufactures motorcycles, scooters and auto rickshaws. Bajaj Auto is a part of the Bajaj Group. It was founded by Jamnalal Bajaj in Rajasthan in the 1940s. It is based in Pune, Maharashtra, with plants in Chakan (Pune), Waluj and Pantnagar in Uttarakhand. The oldest plant at Akurdi (Pune) now houses the R&D centre Ahead.',
                'active' => 1
            ],
            [
                'name' => 'Benelli ',
                'description' => 'Established in 1911, Benelli is one of the oldest Italian motorcycle manufacturers. It once manufactured shotguns, although this part of the business is now a separate company.',
                'active' => 1
            ],
            [
                'name' => 'BMW',
                'description' => 'BMW Indiais a subsidiary of the BMW Group.It is based in India and its headquarters are located in Chennai. Its facilities include a manufacturing plant in Chennai which was built in 2007, a parts warehouse in Mumbai, a training center in Gurugram, NCR, and a network of dealerships. BMW India manufacturers BMW, MINI.',
                'active' => 1
            ],
            [
                'name' => 'BSA',
                'description' => 'The Birmingham Small Arms Company Limited (BSA) was a major British industrial combine, a group of businesses manufacturing military and sporting firearms; bicycles; motorcycles; cars; buses and bodies; steel; iron castings; hand, power, and machine tools; coal cleaning and handling plants; sintered metals; and hard chrome process.',
                'active' => 1
            ],
            [
                'name' => 'Ducati',
                'description' => 'Ducati Motor Holding S.p.A. is the motorcycle-manufacturing division of Italian company Ducati, headquartered in Bologna, Italy. The company is owned by German automotive manufacturer Audi through its Italian subsidiary Lamborghini, which is in turn owned by the Volkswagen Group.',
                'active' => 1
            ],
            [
                'name' => 'Harley-Davidson',
                'description' => 'Harley-Davidson India is a wholly owned subsidiary of Harley-Davidson, based in Gurgaon, Haryana, India. Harley-Davidson India commenced operations in August 2009 and appointed its first dealership in July 2010.',
                'active' => 1
            ],
            [
                'name' => 'Honda',
                'description' => 'Honda Motorcycle and Scooter India, Private Limited (HMSI) is the wholly owned Indian subsidiary of Honda Motor Company, Limited, Japan. Founded in 1999, it was the fourth Honda automotive venture in India, after Kinetic Honda Motor Ltd (1984-1998), Hero Honda (1984-2011) and Honda Siel Cars India (1995-2012). HMSI was established in 1999 at Manesar, District Gurgaon, Haryana.',
                'active' => 1
            ],
            [
                'name' => 'Kawasaki',
                'description' => 'India Kawasaki Motors Private Limited (IKM) is an Indian motorcycle retailer. It was established in May 2010 in Pune,Maharashtra, as a wholly owned subsidiary of Kawasaki Heavy Industries Motorcycle & Engine, Japan Ltd. for imports and sales of motorcycles. Kawasaki made a technical assistance agreement with Bajaj Auto Ltd. in 1984, and cooperated to expand production and sales of motorcycles in India. In November 2016 India Kawasaki Motors decided to break ties with Bajaj Auto Ltd. for sales and service from April 2017 and sell its motorcycles through its own network.',
                'active' => 1
            ],
            [
                'name' => 'KTM',
                'description' => 'KTM AG is an Austrian motorcycle and sports car manufacturer owned by KTM Industries AG and Indian manufacturer Bajaj Auto. It was formed in 1992 but traces its foundation to as early as 1934. Today, KTM AG is the parent company of the KTM Group.',
                'active' => 1
            ],
            [
                'name' => 'Suzuki',
                'description' => 'Suzuki Motorcycle India, Private Limited (SMI) is the wholly owned Indian subsidiary of Suzuki, Japan. It was the third Suzuki automotive venture in India, after TVS Suzuki (1982–2001) and Maruti Suzuki (1982). In 1982, the joint-venture between Suzuki Motor Corporation and TVS Motor Company incorporated and started production of two wheelers in India. In 2001, after separating ways with TVS motor company, the company was re-entered as Suzuki Motorcycle India, Private Limited (SMI), in 2006. The company has set up a manufacturing facility at Gurgaon, Haryana with an annual capacity of 5,40,000 units.',
                'active' => 1
            ],
            [
                'name' => 'TVS',
                'description' => 'TVS Motor Company is a multinational motorcycle company headquartered at Chennai, India. It is the third largest motorcycle company in India with a revenue of over ₹15,000 crore (US$2.1 billion) in 2017-18. The company has an annual sales of 3 million units and an annual capacity of over 4 million vehicles. TVS Motor Company is also the 2nd largest exporter in India with exports to over 60 Countries.',
                'active' => 1
            ],
            [
                'name' => 'Vespa',
                'description' => 'Vespa is an Italian brand of scooter manufactured by Piaggio. The name means wasp in Italian. The Vespa has evolved from a single model motor scooter manufactured in 1946 by Piaggio & Co. S.p.A. of Pontedera, Italy to a full line of scooters and one of seven companies today owned by Piaggio.',
                'active' => 1
            ],
            [
                'name' => 'Velocette',
                'description' => 'Velocette is the name given to motorcycles made by Veloce Ltd, in Hall Green, Birmingham, England. One of several motorcycle manufacturers in Birmingham, Velocette was a small, family-owned firm, selling almost as many hand-built motorcycles during its lifetime, as the mass-produced machines of the giant BSA and Norton concerns. Renowned for the quality of its products, the company was "always in the picture" in international motorcycle racing, from the mid-1920s through the 1950s, culminating in two World Championship titles and its legendary and still-unbeaten 24 hours at over 100 mph (161 km/h) record. Veloce, while small, was a great technical innovator and many of its patented designs are commonplace on motorcycles today, including the positive-stop foot shift and swinging arm rear suspension with hydraulic dampers.',
                'active' => 1
            ],
            [
                'name' => 'Yamaha',
                'description' => 'Yamaha Motor Company Limited is a Japanese manufacturer of motorcycles, marine products such as boats and outboard motors, and other motorized products. The company was established in 1955 upon separation from Yamaha Corporation, and is headquartered in Iwata, Shizuoka, Japan. The company conducts development, production and marketing operations through 109 consolidated subsidiaries as of 2012.',
                'active' => 1
            ],
            [
                'name' => 'Jawa',
                'description' => 'JAWA is a motorcycle and moped manufacturer founded in Prague, Czechoslovakia in 1929 by František Janeček, who bought the motorcycle division of Wanderer. The name JAWA was established by concatenating the first letters of Janeček and Wanderer. In the past, especially in the 1950s, JAWA was one of the top motorcycle manufacturers and exported its 350 into over 120 countries. Another famous model in the 1970s was the 350 Californian. It appeared in the typical black and red coloring from Californian beaches to New Zealand. After 1990, there was a significant loss of production. A successor company was formed in 1997 in Týnec nad Sázavou, continuing the name as JAWA Moto.',
                'active' => 1
            ]
        ];
        foreach ($makes as $make) {
            Make::create($make);
        }
    }
}
