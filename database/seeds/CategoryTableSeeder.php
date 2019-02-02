<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Road Racing',
                'description' => 'Road racing is a form of motorcycle racing held on a paved road surfaces. The races can be held either on a purpose-built closed circuit or on a street circuit utilizing temporarily closed public roads.',
                'active' => true,
                'parent_id' => ''
            ], [
                'name' => 'Traditional road racing',
                'description' => 'Historically, "road racing" meant a course on closed public roads. This was once commonplace but currently only a few such circuits have survived, mostly in Europe. ',
                'active' => true,
                'parent_id' => '1'
            ], [
                'name' => 'Motorcycle grand prix',
                'description' => 'Grand Prix motorcycle racing refers to the premier category of motorcycle road racing.',
                'active' => true,
                'parent_id' => '1'
            ], [
                'name' => 'Superbike racing',
                'description' => 'Superbike racing is the category of motorcycle road racing that employs modified production motorcycles. Superbike racing motorcycles must have four stroke engines of between 800 cc and 1200 cc for twins, and between 750 cc and 1000 cc for four cylinder machines. The motorcycles must maintain the same profile as their roadgoing counterparts. The overall appearance, seen from the front, rear and sides, must correspond to that of the bike homologated for use on public roads even though the mechanical elements of the machine have been modified.',
                'active' => true,
                'parent_id' => '1'
            ], [
                'name' => 'Supersport racing',
                'description' => 'Supersport racing is another category of motorcycle road racing that employs modified production motorcycles. To be eligible for Supersport racing, a motorcycle must have a four-stroke engine of between 400 and 600 cc for four-cylinder machines, and between 600 and 750 cc for twins, and must satisfy the FIM homologation requirements. Supersport regulations are much tighter than Superbikes. Supersport machines must remain largely as standard, while engine tuning is possible but tightly regulated.',
                'active' => true,
                'parent_id' => '1'
            ], [
                'name' => 'Endurance racing',
                'description' => 'Endurance racing is a category of motorcycle road racing which is meant to test the durability of equipment and endurance of the riders. Teams of multiple riders attempt to cover a large distance in a single event. Teams are given the ability to change riders during the race. Endurance races can be run either to cover a set distance in laps as quickly as possible, or to cover as much distance as possible over a preset amount of time. Reliability of the motorcycles used for endurance racing is paramount.',
                'active' => true,
                'parent_id' => '1'
            ], [
                'name' => 'Sidercar racing',
                'description' => 'Sidecar racing is a category of sidecar motorcycle racing. Older sidecar road racers generally resembled solo motorcycles with a platform attached; modern racing sidecars are purpose built low and long vehicles. Sidecarcross resembles MX motorcycles with a high platform attached. In sidecar racing a rider and a passenger work together to make the machine perform optimally; the way in which the passenger shifts their weight across the sidecar is crucial to its performance around corners.

                Sidecar racing has many sub-categories including:
                
                Sidecarcross (sidecar motocross)
                Sidecar trials
                F1/F2 road racing
                Historic (classic) road racing',
                'active' => true,
                'parent_id' => '1'
            ], [
                'name' => 'Motocross',
                'description' => 'Motocross (or MX) is the direct equivalent of road racing, but off-road, a number of bikes racing on a closed circuit. Motocross circuits are constructed on a variety of non-tarmac surfaces such as dirt, sand, mud, grass, etc., and tend to incorporate elevation changes either natural or artificial. Advances in motorcycle technology, especially suspension, have led to the predominance of circuits with added "jumps" on which bikes can get airborne. Motocross has another noticeable difference from road racing, in that starts are done en masse, with the riders alongside each other. Up to 40 riders race into the first corner, and sometimes there is a separate award for the first rider through (see holeshot). The winner is the first rider across the finish line, generally after a given amount of time or laps or a combination.

                Motocross has a plethora of classes based upon machine displacement (ranging from 50cc 2-stroke youth machines up to 250cc two-stroke and 450cc four-stroke), age of competitor, ability of competitor, sidecars, quads/ATVs, and machine age (classic for pre-1965/67, Twinshock for bikes with two shock absorbers, etc.).',
                'active' => true,
                'parent_id' => ''
            ], [
                'name' => 'Suppercross',
                'description' => 'Supercross (or SX) is simply indoor motocross. Supercross is more technical and rhythm like to riders. Typically situated in a variety of stadiums and open or closed arenas, it is notable for its numerous jumps. In North America, this has been turned into an extremely popular spectator sport, filling large baseball, soccer, and football stadiums, leading to Motocross being now termed the "outdoors". However, in Europe it is less popular sport, as the predominate focus there is on Motocross.',
                'active' => true,
                'parent_id' => '2'
            ], [
                'name' => 'Supermoto',
                'description' => 'Supermoto is a racing category that is a crossover between road-racing and motocross. The motorcycles are mainly motocross types with road-racing tyres. The racetrack is a mixture of road and dirt courses (in different proportions) and can take place either on closed circuits or in temporary venues (such as urban locations).

                The riding style on the tarmac section is noticeably different from other forms of tarmac-based racing, with a different line into corners, sliding of the back wheel around the corner, and using the leg straight out to corner (as opposed to the noticeable touching of the bent knee to the tarmac of road racers).',
                'active' => true,
                'parent_id' => '2'
            ], [
                'name' => 'Enduro and cross-country',
                'description' => 'Enduro and cross-country',
                'active' => true,
                'parent_id' => ''
            ], [
                'name' => 'Enduro',
                'description' => 'Enduro is a form of off-road motorcycle sport that primarily focuses on the endurance of the competitor. In the most traditional sense ("Time Card Enduros"), competitors complete a 10+ mile lap, of predominately off-road going, often through forestry. The lap is made up of different stages, each with a target time to complete that stage in exactly, there are penalties for being early and late, thus the goal is to be exactly "on time". Some stages are deliberately "tight", others are lax allowing the competitor to recuperate. There are also a variety of special tests, on variety of terrain to further aid classification, these are speed stages where the fastest time is desired. A normal event lasts for 3 to 4 hours, although longer events are not uncommon. Some events, particularly national and world championship events take place over several days and require maintenance work to be carried out within a limited time window or while the race is running. To prevent circumvention of the maintenance restrictions, the motorcycles are kept overnight in secure storage.',
                'active' => true,
                'parent_id' => '3'
            ], [
                'name' => 'Hare scramble',
                'description' => 'Hare scramble is the name given to a particular form of off-road motorcycle racing. Traditionally a hare scramble can vary in length and time with the contestants completing multiple laps around a marked course through wooded or other rugged natural terrain. The overall winner is the contestant who maintains the highest speed throughout the event. In Florida, Hare scrambles start the race with a staggered starting sequence. Once on the course, the object of the competitor is to complete the circuit as fast as possible. The race consists of wooded areas or open fields.',
                'active' => true,
                'parent_id' => '3'
            ], [
                'name' => 'Cross-country rally',
                'description' => 'Cross-country rally events (also called Rallye Raid or simply Rallye, alternate spelling Rally) are much bigger than enduros. Typically using larger bikes than other off-road sports, these events take place over many days, travelling hundreds of miles across primarily open off-road terrain. The most famous example is the Dakar Rally, previously travelling from Western Europe (often Paris) to Dakar in Senegal, via the Sahara desert, taking almost two weeks. Since 2009 the Dakar Rally has been held in South America traveling through Peru, Argentina and Chile. A FIM Cross-Country Rallies World Championship also exists encompassing many events across the world, typically in desert nations. These events often run alongside "car" rallies (under the FIA).',
                'active' => true,
                'parent_id' => '3'
            ], [
                'name' => 'Track racing',
                'description' => 'Track racing is a form of motorcycle racing where teams or individuals race opponents around an oval track. There are differing variants, with each variant racing on a different surface type.',
                'active' => true,
                'parent_id' => '4'
            ], [
                'name' => 'Indoor short track and TT racing',
                'description' => 'Indoor races consist of either: a polished concrete floor with coke syrup, or other media sprayed or mopped onto the concrete for traction for the tyres of the motorcycles, or on dirt that has been moistened and hard packed, or left loose (often called a cushion). Similar to size of the Arenacross Arenas or sometimes smaller the riders must have accurate throttle control to negotiate these tight Indoor Race Tracks.

                In the U.S., flat-track events are held on outdoor dirt ovals, ranging in length from one mile to half-mile, short-tracks and TTs. All are usually held outdoors, though a few short-track events have been held in indoor stadiums. A Short Track event is one involving a track of less than ​1⁄2 mile in length, while a TT event can be of any length, but it must have at least one right turn and at least one jump to qualify.',
                'active' => true,
                'parent_id' => '4'
            ], [
                'name' => 'Speedway',
                'description' => 'Speedway racing takes place on a flat oval track usually consisting of dirt or loosely packed shale, using bikes with a single gear and no brakes. Competitors use this surface to slide their machines sideways (powersliding or broadsliding) into the bends using the rear wheel to scrub-off speed while still providing the drive to power the bike forward and around the bend.',
                'active' => true,
                'parent_id' => ''
            ], [
                'name' => 'Grasstrack',
                'description' => 'Grasstrack is outdoor speedway. The track are longer (400 m+, hence it is often also referred to as Long Track at world level), often on grass (although other surfaces exist) and even feature elevation changes. Machinery is very similar to a speedway bike (still no brakes, but normally two gears, rear suspension, etc.)',
                'active' => true,
                'parent_id' => '4'
            ], [
                'name' => 'Ice speedway',
                'description' => 'Ice racing includes a motorcycle class which is the equivalent of Speedway on ice. Bikes race anti-clockwise around oval tracks between 260 and 425 metres in length. Metal tire spikes or screws are often allowed to improve traction. The race structure and scoring are similar to Speedway.',
                'active' => true,
                'parent_id' => '4'
            ], [
                'name' => 'Board track',
                'description' => 'Board track racing was a type of track racing popular in the United States between the second and third decades of the 20th century, where competition was conducted on oval race courses with surfaces composed of wooden planks. By the early 1930s, board track racing had fallen out of favor, and into eventual obsolescence.',
                'active' => true,
                'parent_id' => '4'
            ], [
                'name' => 'Auto race',
                'description' => 'Auto Race is a Japanese version of track racing held on an asphalt oval course and seen as a gambling sport.',
                'active' => true,
                'parent_id' => '4'
            ], [
                'name' => 'Others',
                'description' => 'Other categories',
                'active' => true,
                'parent_id' => ''
            ], [
                'name' => 'Drag racing/sprints',
                'description' => 'Drag racing or sprints is a racing venue where two participants line up at a dragstrip with a signaled starting line. Upon the starting signal, the riders accelerate down a straight, quarter-mile long paved track where their elapsed time and terminal speed are recorded. The rider to reach the finish line first is the winner. This can occur upon purpose built venues (e.g., Santa Pod), temporary venues (e.g., runways or drives of country houses). In addition to "regular" motorcycles, top fuel motorcycles using Nitrous Oxide also compete in this category.',
                'active' => true,
                'parent_id' => '5'
            ], [
                'name' => 'UK sprinting',
                'description' => 'The UK National Sprint Association was formed in 1958.[6] The president was Donald Campbell until his death in 1967, succeeded by former Vincent employee and sprint-record holder George Brown, who retired from sport in 1966 on reaching the 55 age-limit for the ACU competition licence. Brown\'s machines included the V twin Vincent-engined, normally-aspirated Nero, and the supercharged version Super Nero',
                'active' => true,
                'parent_id' => '5'
            ], [
                'name' => 'Hill climb',
                'description' => 'In hill climbing, a single rider climbs or tries to climb a road going up a hill in the fastest time or the furthest up the hill before ceasing forward motion. Tarmac events are typically on closed public roads and private roads. The same concept is also used off-tarmac, usually on steeper hills.',
                'active' => true,
                'parent_id' => '5'
            ], [
                'name' => 'Landspeed racing',
                'description' => 'In Landspeed motorcycle racing, the racer is trying to beat the fastest speed ever achieved by that style of motorcycle and type of engine for a timed mile. The pre-eminent event for motorcycle LSR is the International Motorcycle Speed Trials by BUB, held on the Bonneville Salt Flats annually (near Labor Day). Motorcycles are classified based on body style, i.e. how much streamlining is incorporated. They are further classified based on engine size in cubic centimeters (cc\'s) and based on fuel type (gasoline versus any modified fuels).',
                'active' => true,
                'parent_id' => '5'
            ], [
                'name' => 'Vintage',
                'description' => 'In vintage racing riders race classic motorcycles that are no longer competitive with the latest production motorcycles. Classes are organized by production period and engine displacement. There are vintage events for almost every type of racing listed above, vintage motocross and road racing are especially popular. Equipment is limited to that available for the production period, although modern safety equipment and tires are permitted. Most vintage production periods are from the 1970s and before, but now 1980s motorcycles are being allowed into some events, although this has met with some opposition from traditionalists.[citation needed] Generally a motorcycle must be at least 25 years old to be considered vintage.',
                'active' => true,
                'parent_id' => '5'
            ], [
                'name' => 'Supper hooligan',
                'description' => 'Hooligan racing has been around since the 1970s when fans attending flat track races began racing their own personal motorcycles during intermissions of events. Often these motorcycles were simply the bikes that fans rode to the event also known as "run what you brung" races. What\'s now known as "Super Hooligan" came out of the Harley nights at Costa Mesa Speedway in Southern California. Southern California motorcycle culture developed around this idea of racing large V Twin motorcycles. Super Hooligan races have been side entertainment at a number of events from bike shows like the Handbuilt in Austin, The One Show in Portland to the Superprestigio of the Americas in Las Vegas in 2016, to the flat track races held in conjunction with MotoGP at Circuit of the Americas. In 2017 Super Hooligan became an official racing series with 10 races on the calendar for that year from February through October',
                'active' => true,
                'parent_id' => '5'
            ]
        ];
        // create colors
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
