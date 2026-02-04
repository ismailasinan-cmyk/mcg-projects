@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1 letter-spacing-tight">Edit Tracking Entry</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.tracking.index') }}" class="text-decoration-none">Tracking</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        <div class="d-none d-md-block">
            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-normal">
                <i class="bi bi-calendar3 me-2 text-muted"></i> {{ date('l, F j, Y') }}
            </span>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header border-bottom bg-white py-3 px-4 d-flex justify-content-between align-items-center">
                     <h5 class="mb-0 fw-bold text-dark">Entry Details</h5>
                     <span class="badge bg-light text-dark">ID: #{{ $tracking->id }}</span>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger rounded-3 mb-4">
                            <ul class="mb-0 small">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.tracking.update', $tracking) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control bg-light border-0" id="date" name="date" value="{{ old('date', $tracking->date ? $tracking->date->format('Y-m-d') : '') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="company" class="form-label">Company <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light border-0" id="company" name="company" value="{{ old('company', $tracking->company) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="client" class="form-label">Client <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light border-0" id="client" name="client" value="{{ old('client', $tracking->client) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="project" class="form-label">Project Title <span class="text-danger">*</span></label>
                            <textarea class="form-control bg-light border-0" id="project" name="project" rows="2" required>{{ old('project', $tracking->project) }}</textarea>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="bg-light rounded-3 p-3 h-100">
                                    <label class="form-label fw-bold small text-muted text-uppercase mb-3">Location</label>
                                    
                                    <div class="mb-3">
                                        <label for="country" class="form-label small">Country <span class="text-danger">*</span></label>
                                        <select class="form-select border-0 shadow-none bg-white" id="country" name="country" onchange="toggleCountry(this)" required>
                                            <option value="Nigeria" {{ old('country', $tracking->country ?? 'Nigeria') == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                                            <option value="Others" {{ old('country', $tracking->country ?? 'Nigeria') != 'Nigeria' ? 'selected' : '' }}>Others</option>
                                        </select>
                                    </div>
                                    
                                    <div id="state_wrapper" class="mb-3">
                                        <label for="state" class="form-label small">State</label>
                                        <select class="form-select border-0 shadow-none bg-white" id="state" name="state" onchange="loadLGAs(this)" required>
                                            <option value="">Select State</option>
                                        </select>
                                    </div>
                                    
                                    <div id="lga_wrapper">
                                        <label for="lga" class="form-label small">LGA / City</label>
                                        <select class="form-select border-0 shadow-none bg-white" id="lga" name="lga">
                                            <option value="">Select LGA</option>
                                        </select>
                                    </div>

                                    <input type="text" class="form-control mt-2" id="state_input" name="state_text" style="display: none;" disabled placeholder="Enter State" value="{{ old('state_text', $tracking->country != 'Nigeria' ? $tracking->state : '') }}">
                                    <input type="text" class="form-control mt-2" id="lga_input" name="lga_text" style="display: none;" disabled placeholder="Enter LGA/City" value="{{ old('lga_text', $tracking->country != 'Nigeria' ? $tracking->lga : '') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light rounded-3 p-3 h-100">
                                    <label class="form-label fw-bold small text-muted text-uppercase mb-3">Status & Cost</label>
                                    
                                    <div class="mb-3">
                                        <label for="status" class="form-label small">Current Status <span class="text-danger">*</span></label>
                                        <select class="form-select border-0 shadow-none bg-white" id="status" name="status" required>
                                            <option value="moving_forward" {{ old('status', $tracking->status) == 'moving_forward' ? 'selected' : '' }}>Moving Forward</option>
                                            <option value="in_progress" {{ old('status', $tracking->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="no_progress" {{ old('status', $tracking->status) == 'no_progress' ? 'selected' : '' }}>No Progress</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="cost" class="form-label small">Project Cost (₦)</label>
                                        <div class="input-group bg-white rounded-3 overflow-hidden">
                                            <span class="input-group-text border-0 bg-transparent text-muted">₦</span>
                                            <input type="number" step="0.01" class="form-control border-0 shadow-none ps-1" id="cost" name="cost" value="{{ old('cost', $tracking->cost) }}" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="activity" class="form-label">Current Activity</label>
                                <textarea class="form-control bg-light border-0" id="activity" name="activity" rows="3">{{ old('activity', $tracking->activity) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="progress" class="form-label">Progress Details</label>
                                <textarea class="form-control bg-light border-0" id="progress" name="progress" rows="3">{{ old('progress', $tracking->progress) }}</textarea>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="responsible" class="form-label">Person Responsible</label>
                            <div class="input-group">
                                <select class="form-select bg-light border-0" id="responsible_select" onchange="toggleResponsibleInput(this)">
                                    <option value="">Select Responsible Person</option>
                                    <option value="Dr. Nasir Usman Imam">Dr. Nasir Usman Imam</option>
                                    <option value="Mr. Ibrahim Usman Imam">Mr. Ibrahim Usman Imam</option>
                                    <option value="Engr. Abdulhakeem Ali">Engr. Abdulhakeem Ali</option>
                                    <option value="Dr. Sinan Ismaila Idris">Dr. Sinan Ismaila Idris</option>
                                    <option value="Aisha Usman">Aisha Usman</option>
                                    <option value="Ramatu Lawan">Ramatu Lawan</option>
                                    <option value="others">Other (Specify)</option>
                                </select>
                            </div>
                            <input type="text" class="form-control mt-2" id="responsible" name="responsible" value="{{ old('responsible', $tracking->responsible) }}" style="display: none;" placeholder="Enter Name">
                        </div>
                        
                        <!-- Documents -->
                        <div class="mb-4">
                            <label class="form-label">Documents</label>
                            @if($tracking->documents->count() > 0)
                                <div class="list-group border-0 shadow-sm rounded-3 mb-3">
                                    @foreach($tracking->documents as $doc)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <i class="{{ $doc->icon }} me-3 text-primary fs-5"></i>
                                                <div>
                                                    <div class="fw-medium">{{ $doc->file_name }}</div>
                                                    <small class="text-muted">{{ $doc->file_size }}</small>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ route('admin.tracking.document.download', $doc) }}" class="btn btn-sm btn-light border">
                                                     <i class="bi bi-download"></i>
                                                </a>
                                                <div class="form-check m-0">
                                                    <input class="form-check-input" type="checkbox" name="delete_documents[]" value="{{ $doc->id }}" id="del_{{ $doc->id }}">
                                                    <label class="form-check-label text-danger small" for="del_{{ $doc->id }}">Delete</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="upload-zone p-4 rounded-3 border-dashed bg-light text-center">
                                <div id="document-upload-container">
                                    <div class="document-upload-row mb-2">
                                        <input type="file" name="documents[]" class="form-control" accept=".pdf,image/*">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addDocRow()">
                                    <i class="bi bi-plus-lg me-1"></i> Add Another Document
                                </button>
                                <p class="text-muted small mt-2 mb-0">Accepted: PDF and Images (JPG, PNG). Max 100MB.</p>
                            </div>
                        </div>

                        <div class="progress-container d-none mb-3">
                            <div class="progress shadow-sm" style="height: 20px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%">0%</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between pt-3 border-top">
                             <button type="button" class="btn btn-outline-danger rounded-3" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="bi bi-trash me-2"></i>Delete Entry
                            </button>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.tracking.index') }}" class="btn btn-light border py-2 px-4 rounded-3">Cancel</a>
                                <button type="submit" class="btn btn-primary py-2 px-4 rounded-3 shadow-sm fw-bold">Update Entry</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-body p-4 text-center">
                <i class="bi bi-exclamation-circle text-danger display-1 mb-3"></i>
                <h5 class="fw-bold mb-2">Delete Tracking Entry?</h5>
                <p class="text-muted mb-4">This action cannot be undone. Are you sure you want to proceed?</p>
                <form action="{{ route('admin.tracking.destroy', $tracking) }}" method="POST" class="d-flex justify-content-center gap-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger px-4 rounded-3">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const nigeriaData = {
        "Abia": ["Aba North", "Aba South", "Arochukwu", "Bende", "Ikwuano", "Isiala Ngwa North", "Isiala Ngwa South", "Isuikwuato", "Obi Ngwa", "Ohafia", "Osisioma", "Ugwunagbo", "Ukwa East", "Ukwa West", "Umuahia North", "Umuahia South", "Umu Nneochi"],
        "Adamawa": ["Demsa", "Fufure", "Ganye", "Gayuk", "Gombi", "Grie", "Hong", "Jada", "Lamurde", "Madagali", "Maiha", "Mayo Belwa", "Michika", "Mubi North", "Mubi South", "Numan", "Shelleng", "Song", "Toungo", "Yola North", "Yola South"],
        "Akwa Ibom": ["Abak", "Eastern Obolo", "Eket", "Esit Eket", "Essien Udim", "Etim Ekpo", "Etinan", "Ibeno", "Ibesikpo Asutan", "Ibiono-Ibom", "Ika", "Ikono", "Ikot Abasi", "Ikot Ekpene", "Ini", "Itu", "Mbo", "Mkpat-Enin", "Nsit-Atai", "Nsit-Ibom", "Nsit-Ubium", "Obot Akara", "Okobo", "Onna", "Oron", "Oruk Anam", "Udung-Uko", "Ukanafun", "Uruan", "Urue-Offong/Oruko", "Uyo"],
        "Anambra": ["Aguata", "Anambra East", "Anambra West", "Anaocha", "Awka North", "Awka South", "Ayamelum", "Dunukofia", "Ekwusigo", "Idemili North", "Idemili South", "Ihiala", "Njikoka", "Nnewi North", "Nnewi South", "Ogbaru", "Onitsha North", "Onitsha South", "Orumba North", "Orumba South", "Oyi"],
        "Bauchi": ["Alkaleri", "Bauchi", "Bogoro", "Damban", "Darazo", "Dass", "Gamawa", "Ganjuwa", "Giade", "Itas/Gadau", "Jama'are", "Katagum", "Kirfi", "Misau", "Ningi", "Shira", "Tafawa Balewa", "Toro", "Warji", "Zaki"],
        "Bayelsa": ["Brass", "Ekeremor", "Kolokuma/Opokuma", "Nembe", "Ogbia", "Sagbama", "Southern Ijaw", "Yenagoa"],
        "Benue": ["Ado", "Agatu", "Apa", "Buruku", "Gboko", "Guma", "Gwer East", "Gwer West", "Katsina-Ala", "Konshisha", "Kwande", "Logo", "Makurdi", "Obi", "Ogbadibo", "Ohimini", "Oju", "Okpokwu", "Otukpo", "Tarka", "Ukum", "Ushongo", "Vandeikya"],
        "Borno": ["Abadam", "Askira/Uba", "Bama", "Bayo", "Biu", "Chibok", "Damboa", "Dikwa", "Gubio", "Guzamala", "Gwoza", "Hawul", "Jere", "Kaga", "Kala/Balge", "Konduga", "Kukawa", "Kwaya Kusar", "Mafa", "Magumeri", "Maiduguri", "Marte", "Mobbar", "Monguno", "Ngala", "Nganzai", "Shani"],
        "Cross River": ["Abi", "Akamkpa", "Akpabuyo", "Bakassi", "Bekwarra", "Biase", "Boki", "Calabar Municipal", "Calabar South", "Etung", "Ikom", "Obanliku", "Obubra", "Obudu", "Odukpani", "Ogoja", "Yakuur", "Yala"],
        "Delta": ["Aniocha North", "Aniocha South", "Bomadi", "Burutu", "Ethiope East", "Ethiope West", "Ika North East", "Ika South", "Isoko North", "Isoko South", "Ndokwa East", "Ndokwa West", "Okpe", "Oshimili North", "Oshimili South", "Patani", "Sapele", "Udu", "Ughelli North", "Ughelli South", "Ukwuani", "Uvwie", "Warri North", "Warri South", "Warri South West"],
        "Ebonyi": ["Abakaliki", "Afikpo North", "Afikpo South", "Ebonyi", "Ezza North", "Ezza South", "Ikwo", "Ishielu", "Ivo", "Izzi", "Ohaozara", "Ohaukwu", "Onicha"],
        "Edo": ["Akoko-Edo", "Egor", "Esan Central", "Esan North-East", "Esan South-East", "Esan West", "Etsako Central", "Etsako East", "Etsako West", "Igueben", "Ikpoba Okha", "Orhionmwon", "Ovia North-East", "Ovia South-West", "Owan East", "Owan West", "Uhunmwonde"],
        "Ekiti": ["Ado Ekiti", "Efon", "Ekiti East", "Ekiti South-West", "Ekiti West", "Emure", "Gbonyin", "Ido Osi", "Ijero", "Ikere", "Ikole", "Ilejemeje", "Irepodun/Ifelodun", "Ise/Orun", "Moba", "Oye"],
        "Enugu": ["Aninri", "Awgu", "Enugu East", "Enugu North", "Enugu South", "Ezeagu", "Igbo Etiti", "Igbo Eze North", "Igbo Eze South", "Isi Uzo", "Nkanu East", "Nkanu West", "Nsukka", "Oji River", "Udenu", "Udi", "Uzo Uwani"],
        "FCT": ["Abaji", "Bwari", "Gwagwalada", "Kuje", "Kwali", "Municipal Area Council"],
        "Gombe": ["Akko", "Balanga", "Billiri", "Dukku", "Funakaye", "Gombe", "Kaltungo", "Kwami", "Nafada", "Shongom", "Yamaltu/Deba"],
        "Imo": ["Aboh Mbaise", "Ahiazu Mbaise", "Ehime Mbano", "Ezinihitte", "Ideato North", "Ideato South", "Ihitte/Uboma", "Ikeduru", "Isiala Mbano", "Isu", "Mbaitoli", "Ngor Okpala", "Njaba", "Nkwerre", "Nwangele", "Obowo", "Oguta", "Ohaji/Egbema", "Okigwe", "Orlu", "Orsu", "Oru East", "Oru West", "Owerri Municipal", "Owerri North", "Owerri West"],
        "Jigawa": ["Auyo", "Babura", "Biriniwa", "Birnin Kudu", "Buji", "Dutse", "Gagarawa", "Garki", "Gumel", "Guri", "Gwaram", "Gwiwa", "Hadejia", "Jahun", "Kafin Hausa", "Kaugama", "Kazaure", "Kiri Kasama", "Kiyawa", "Maigatari", "Malam Madori", "Miga", "Ringim", "Roni", "Sule Tankarkar", "Taura", "Yankwashi"],
        "Kaduna": ["Birnin Gwari", "Chikun", "Giwa", "Igabi", "Ikara", "Jaba", "Jema'a", "Kachia", "Kaduna North", "Kaduna South", "Kagarko", "Kajuru", "Kaura", "Kauru", "Kubau", "Kudan", "Lere", "Makarfi", "Sabon Gari", "Sanga", "Soba", "Zangon Kataf", "Zaria"],
        "Kano": ["Ajingi", "Albasu", "Bagwai", "Bebeji", "Bichi", "Bunkure", "Dala", "Dambatta", "Dawakin Kudu", "Dawakin Tofa", "Doguwa", "Fagge", "Gabasawa", "Garko", "Garun Mallam", "Gaya", "Gezawa", "Gwale", "Gwarzo", "Kabo", "Kano Municipal", "Karaye", "Kibiya", "Kiru", "Kumbotso", "Kunchi", "Kura", "Madobi", "Makoda", "Minjibir", "Nassarawa", "Rano", "Rimin Gado", "Rogo", "Shanono", "Sumaila", "Takai", "Tarauni", "Tofa", "Tsanyawa", "Tudun Wada", "Ungogo", "Warawa", "Wudil"],
        "Katsina": ["Bakori", "Batagarawa", "Batsari", "Baure", "Bindawa", "Charanchi", "Dandume", "Danja", "Dan Musa", "Daura", "Dutsi", "Dutsin Ma", "Faskari", "Funtua", "Ingawa", "Jibia", "Kafur", "Kaita", "Kankara", "Kankia", "Katsina", "Kurfi", "Kusada", "Mai'Adua", "Malumfashi", "Mani", "Mashi", "Matazu", "Musawa", "Rimi", "Sabuwa", "Safana", "Sandamu", "Zango"],
        "Kebbi": ["Aleiro", "Arewa Dandi", "Argungu", "Augie", "Bagudo", "Birnin Kebbi", "Bunza", "Dandi", "Fakai", "Gwandu", "Jega", "Kalgo", "Koko/Besse", "Maiyama", "Ngaski", "Sakaba", "Shanga", "Suru", "Wasagu/Danko", "Yauri", "Zuru"],
        "Kogi": ["Adavi", "Ajaokuta", "Ankpa", "Bassa", "Dekina", "Ibaji", "Idah", "Igalamela Odolu", "Ijumu", "Kabba/Bunu", "Kogi", "Lokoja", "Mopa Muro", "Ofu", "Ogori/Magongo", "Okehi", "Okene", "Olamaboro", "Omala", "Yagba East", "Yagba West"],
        "Kwara": ["Asa", "Baruten", "Edu", "Ekiti", "Ifelodun", "Ilorin East", "Ilorin South", "Ilorin West", "Irepodun", "Isin", "Kaiama", "Moro", "Offa", "Oke Ero", "Oyun", "Pategi"],
        "Lagos": ["Agege", "Ajeromi-Ifelodun", "Alimosho", "Amuwo-Odofin", "Apapa", "Badagry", "Epe", "Eti Osa", "Ibeju-Lekki", "Ifako-Ijaiye", "Ikeja", "Ikorodu", "Kosofe", "Lagos Island", "Lagos Mainland", "Mushin", "Ojo", "Oshodi-Isolo", "Shomolu", "Surulere"],
        "Nasarawa": ["Akwanga", "Awe", "Doma", "Karu", "Keana", "Keffi", "Kokona", "Lafia", "Nasarawa", "Nasarawa Egon", "Obi", "Toto", "Wamba"],
        "Niger": ["Agaie", "Agwara", "Bida", "Borgu", "Bosso", "Chanchaga", "Edati", "Gbako", "Gurara", "Katcha", "Kontagora", "Lapai", "Lavun", "Magama", "Mariga", "Mashegu", "Mokwa", "Muya", "Pailoro", "Rafi", "Rijau", "Shiroro", "Suleja", "Tafa", "Wushishi"],
        "Ogun": ["Abeokuta North", "Abeokuta South", "Ado-Odo/Ota", "Egbado North", "Egbado South", "Ewekoro", "Ifo", "Ijebu East", "Ijebu North", "Ijebu North East", "Ijebu Ode", "Ikenne", "Imeko Afon", "Ipokia", "Obafemi Owode", "Odeda", "Odogbolu", "Ogun Waterside", "Remo North", "Shagamu"],
        "Ondo": ["Akoko North-East", "Akoko North-West", "Akoko South-East", "Akoko South-West", "Akure North", "Akure South", "Ese Odo", "Idanre", "Ifedore", "Ilaje", "Ile Oluji/Okeigbo", "Irele", "Odigbo", "Okitipupa", "Ondo East", "Ondo West", "Ose", "Owo"],
        "Osun": ["Atakunmosa East", "Atakunmosa West", "Ayedaade", "Ayedire", "Boluwaduro", "Boripe", "Ede North", "Ede South", "Egbedore", "Ejigbo", "Ife Central", "Ife East", "Ife North", "Ife South", "Ifedayo", "Ifelodun", "Ila", "Ilesa East", "Ilesa West", "Irepodun", "Irewole", "Isokan", "Iwo", "Obokun", "Odo Otin", "Ola Oluwa", "Olorunda", "Oriade", "Orolu", "Osogbo"],
        "Oyo": ["Afijio", "Akinyele", "Atiba", "Atisbo", "Egbeda", "Ibadan North", "Ibadan North-East", "Ibadan North-West", "Ibadan South-East", "Ibadan South-West", "Ibarapa Central", "Ibarapa East", "Ibarapa North", "Ido", "Irepo", "Iseyin", "Itesiwaju", "Iwajowa", "Kajola", "Lagelu", "Ogbomosho North", "Ogbomosho South", "Ogo Oluwa", "Olorunsogo", "Oluyole", "Ona Ara", "Orelope", "Ori Ire", "Oyo East", "Oyo West", "Saki East", "Saki West", "Surulere"],
        "Plateau": ["Barkin Ladi", "Bassa", "Bokkos", "Jos East", "Jos North", "Jos South", "Kanam", "Kanke", "Langtang North", "Langtang South", "Mangu", "Mikang", "Pankshin", "Qua'an Pan", "Riyom", "Shendam", "Wase"],
        "Rivers": ["Abua/Odual", "Ahoada East", "Ahoada West", "Akuku-Toru", "Andoni", "Asari-Toru", "Bonny", "Degema", "Eleme", "Emohua", "Etche", "Gokana", "Ikwerre", "Khana", "Obio/Akpor", "Ogba/Egbema/Ndoni", "Ogu/Bolo", "Okrika", "Omuma", "Opobo/Nkoro", "Oyigbo", "Port Harcourt", "Tai"],
        "Sokoto": ["Binji", "Bodinga", "Dange Shuni", "Gada", "Goronyo", "Gudu", "Gwadabawa", "Illela", "Isa", "Kebbe", "Kware", "Rabah", "Sabon Birni", "Shagari", "Silame", "Sokoto North", "Sokoto South", "Tambuwal", "Tangaza", "Tureta", "Wamakko", "Wurno", "Yabo"],
        "Taraba": ["Ardo Kola", "Bali", "Donga", "Gashaka", "Gassol", "Ibi", "Jalingo", "Karim Lamido", "Kurmi", "Lau", "Sardauna", "Takum", "Ussa", "Wukari", "Yorro", "Zing"],
        "Yobe": ["Bade", "Bursari", "Damaturu", "Fika", "Fune", "Geidam", "Gujba", "Gulani", "Jakusko", "Karasuwa", "Machina", "Nangere", "Nguru", "Potiskum", "Tarmuwa", "Yunusari", "Yusufari"],
        "Zamfara": ["Anka", "Bakura", "Birnin Magaji/Kiyaw", "Bukkuyum", "Bungudu", "Chafe", "Gummi", "Gusau", "Kaura Namoda", "Maradun", "Maru", "Shinkafi", "Talata Mafara", "Zurmi"]
    };

    function addDocRow() {
        var container = document.getElementById('document-upload-container');
        var newRow = document.createElement('div');
        newRow.className = 'document-upload-row mb-2';
        newRow.innerHTML = `
            <div class="input-group">
                <input type="file" name="documents[]" class="form-control" accept=".pdf,image/*">
                <button type="button" class="btn btn-outline-danger" onclick="removeDocRow(this)">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        `;
        container.appendChild(newRow);
    }

    function removeDocRow(btn) {
        btn.closest('.document-upload-row').remove();
    }

    function toggleCountry(select) {
        var stateSelect = document.getElementById('state');
        var stateWrapper = document.getElementById('state_wrapper');
        var stateInput = document.getElementById('state_input');
        
        var lgaSelect = document.getElementById('lga');
        var lgaWrapper = document.getElementById('lga_wrapper');
        var lgaInput = document.getElementById('lga_input');
        
        if(select.value === 'Nigeria') {
            stateWrapper.style.display = 'block';
            stateInput.style.display = 'none';
            stateInput.disabled = true;
            stateSelect.disabled = false;
            
            if(stateSelect.options.length <= 1) {
                Object.keys(nigeriaData).sort().forEach(function(state) {
                    var option = document.createElement('option');
                    option.value = state;
                    option.textContent = state;
                    stateSelect.appendChild(option);
                });
            }
            
            lgaWrapper.style.display = 'block';
            lgaInput.style.display = 'none';
            lgaInput.disabled = true;
        } else {
            stateWrapper.style.display = 'none';
            stateInput.style.display = 'block';
            stateInput.disabled = false;
            stateSelect.disabled = true;
            
            lgaWrapper.style.display = 'none';
            lgaInput.style.display = 'block';
            lgaInput.disabled = false;
        }
    }

    function loadLGAs(stateSelect, currentLGA = '') {
        var lgaSelect = document.getElementById('lga');
        var state = stateSelect.value;
        
        lgaSelect.innerHTML = '<option value="">Select LGA</option>';
        
        if(state && nigeriaData[state]) {
            nigeriaData[state].sort().forEach(function(lga) {
                var option = document.createElement('option');
                option.value = lga;
                option.textContent = lga;
                if(lga === currentLGA) option.selected = true;
                lgaSelect.appendChild(option);
            });
        }
    }

    function toggleResponsibleInput(select) {
        var input = document.getElementById('responsible');
        if(select.value === 'others') {
            input.style.display = 'block';
            input.value = '';
            input.focus();
        } else {
            input.style.display = 'none';
            input.value = select.value;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        new FileUploadHandler('form[action*="update"]', '.progress-bar', {
            redirectUrl: "{{ route('admin.tracking.index') }}"
        });

        // Initialize responsible select
        var input = document.getElementById('responsible');
        var select = document.getElementById('responsible_select');
        
        if(input.value) {
            var found = false;
            for(var i=0; i<select.options.length; i++) {
                if(select.options[i].value === input.value) {
                    select.selectedIndex = i;
                    input.style.display = 'none';
                    found = true;
                    break;
                }
            }
            if(!found) {
                select.value = 'others';
                input.style.display = 'block';
            }
        }

        // Initialize Country/State/LGA
        var countrySelect = document.getElementById('country');
        if(countrySelect) {
            toggleCountry(countrySelect);
            
            var savedState = "{{ $tracking->country == 'Nigeria' ? $tracking->state : '' }}";
            var savedLGA = "{{ $tracking->country == 'Nigeria' ? $tracking->lga : '' }}";
            
            if(countrySelect.value === 'Nigeria' && savedState) {
                var stateSelect = document.getElementById('state');
                stateSelect.value = savedState;
                loadLGAs(stateSelect, savedLGA);
            }
        }
    });
</script>
@endsection