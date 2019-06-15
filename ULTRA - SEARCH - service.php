/**
 * LARAVEL SEARCH
 * - search user input
 */

/**
 * Search User (USER MODEL)
 * @param  [mixed] $query   [description]
 * @param  [string] $keyword [user search input phrase]
 * @return [mixed]          [search results]
 */
public function scopeSearchUser($query, $keyword)
{
    if ($keyword!='') {
        $query->where(function ($query) use ($keyword) {
            $query->where("GIVENNAME", "LIKE","%$keyword%")
                ->orWhere("SN", "LIKE", "%$keyword%");
        });
    }
    return $query;
}
/**
 * Controller
 */
$keyword = Input::get('keyword', '');
$users = User::SearchByKeyword($keyword)->get();




public function search(Request $request) {
    $keyword = $request->{'search'};


    $institutions = DB::table('institution')
                ->select('ID', 'NAME')
                ->get();

    $users = DB::table('user')
                ->select('ID', 'INST_ID', 'GIVENNAME', 'SN', 'OU', 'TELEPHONENUMBER', 'MAIL')
                ->where("GIVENNAME", "LIKE","%$keyword%")
                ->orWhere("SN", "LIKE", "%$keyword%")
                ->get();

    $services = DB::table('sluzba')
                ->select('ID', 'NAZIV', 'OPIS', 'RADNO_VRIJEME', 'INST_ID')
                ->where("NAZIV", "LIKE","%$keyword%")
                ->get();

    $users_count = count($users);
    /**
     * Create Users array for each institution & push found users
     * @var integer
     */
    for ($i = 0; $i < count($institutions); $i++) {
        $institutions[$i]->USERS = [];
        for ($j = 0; $j < count($users); $j++) {
            if($institutions[$i]->ID == $users[$j]->INST_ID) {
                array_push($institutions[$i]->USERS, $users[$j]);
            }
        }
    }


    $services_count = count($services);
    /**
     * Create Services array for each institution & push found services
     */
    for ($s = 0; $s < count($institutions); $s++) {
        $institutions[$s]->SERVICES = [];
        for ($t = 0; $t < count($services); $t++) {
            if($institutions[$s]->ID == $services[$t]->INST_ID) {
                array_push($institutions[$s]->SERVICES, $services[$t]);
            }
        }
    }

    return view('pages.search-result')
                ->with('keyword', $keyword)
                ->with('users_count', $users_count)
                ->with('services_count', $services_count)
                ->with('institutions', $institutions);
}
