// ===================================================================
// APP.JSX — React CRUD app ng Tree Planting
// -------------------------------------------------------------------
// Kaparehong 3-component na istruktura ng events/cleanup/app.jsx:
//   1. App (Parent)             -> useState + useEffect
//   2. RegistrationForm (Child) -> props
//   3. RegistrationList (Child) -> props
// May "seedlings" field dito sa halip na "bring_gloves".
// ===================================================================

const { useState, useEffect } = React;

const EMPTY_FORM = {
    full_name: '',
    email: '',
    contact_number: '',
    purok_sitio: '',
    seedlings: 1,
    notes: '',
};

function RegistrationForm({ formData, onChange, onSubmit, editing, onCancelEdit }) {
    function handleField(e) {
        const { name, value, type } = e.target;
        onChange(name, type === 'number' ? Number(value) : value);
    }

    return (
        <form className="card" onSubmit={onSubmit}>
            <h2 style={{ fontSize: '1.15rem' }}>
                {editing ? 'I-edit ang Registration' : 'Bagong Registration'}
            </h2>

            <div className="field">
                <label htmlFor="full_name">Buong Pangalan</label>
                <input id="full_name" name="full_name" required
                    value={formData.full_name} onChange={handleField} />
            </div>

            <div className="field">
                <label htmlFor="email">Email</label>
                <input id="email" name="email" type="email" required
                    value={formData.email} onChange={handleField} />
            </div>

            <div className="field">
                <label htmlFor="contact_number">Contact Number</label>
                <input id="contact_number" name="contact_number" required
                    value={formData.contact_number} onChange={handleField} />
            </div>

            <div className="field">
                <label htmlFor="purok_sitio">Purok / Sitio</label>
                <input id="purok_sitio" name="purok_sitio" required
                    value={formData.purok_sitio} onChange={handleField} />
            </div>

            <div className="field">
                <label htmlFor="seedlings">Bilang ng Seedlings na Dadalhin</label>
                <input id="seedlings" name="seedlings" type="number" min="1" required
                    value={formData.seedlings} onChange={handleField} />
            </div>

            <div className="field">
                <label htmlFor="notes">Note (optional)</label>
                <textarea id="notes" name="notes" rows="2" value={formData.notes} onChange={handleField}></textarea>
            </div>

            <div style={{ display: 'flex', gap: '0.6rem' }}>
                <button type="submit" className="btn btn-primary" style={{ flex: 1, justifyContent: 'center' }}>
                    {editing ? 'I-save ang changes' : 'Magparehistro'}
                </button>
                {editing && (
                    <button type="button" className="btn btn-ghost" onClick={onCancelEdit}>Kanselahin</button>
                )}
            </div>
        </form>
    );
}

function RegistrationList({ list, onEdit, onDelete }) {
    if (list.length === 0) {
        return <div className="empty-state">Wala pang naka-rehistro. Ikaw na ang una! 🌱</div>;
    }

    return (
        <div className="reg-list">
            {list.map(item => (
                <div className="reg-item" key={item.id}>
                    <div>
                        <h3>{item.full_name}</h3>
                        <p>{item.email} · {item.contact_number}</p>
                        <p>Purok/Sitio: {item.purok_sitio}</p>
                        {item.notes && <p style={{ fontStyle: 'italic' }}>"{item.notes}"</p>}
                        <span className="pill">{item.seedlings} seedling{item.seedlings > 1 ? 's' : ''}</span>
                    </div>
                    <div className="reg-actions">
                        <button className="btn-ghost" onClick={() => onEdit(item)}>Edit</button>
                        <button className="btn-danger" onClick={() => onDelete(item.id)}>Delete</button>
                    </div>
                </div>
            ))}
        </div>
    );
}

function App() {
    const [list, setList] = useState([]);
    const [formData, setFormData] = useState(EMPTY_FORM);
    const [editingId, setEditingId] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        loadRegistrations();
    }, []);

    function loadRegistrations() {
        setLoading(true);
        fetch('api.php')
            .then(res => res.json())
            .then(data => setList(data))
            .catch(() => setList([]))
            .finally(() => setLoading(false));
    }

    function handleChange(name, value) {
        setFormData(prev => ({ ...prev, [name]: value }));
    }

    function handleSubmit(e) {
        e.preventDefault();
        const method = editingId ? 'PUT' : 'POST';
        const url = editingId ? `api.php?id=${editingId}` : 'api.php';

        fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData),
        })
            .then(res => res.json())
            .then(() => {
                setFormData(EMPTY_FORM);
                setEditingId(null);
                loadRegistrations();
            });
    }

    function handleEdit(item) {
        setEditingId(item.id);
        setFormData({
            full_name: item.full_name,
            email: item.email,
            contact_number: item.contact_number,
            purok_sitio: item.purok_sitio,
            seedlings: item.seedlings,
            notes: item.notes || '',
        });
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function handleCancelEdit() {
        setEditingId(null);
        setFormData(EMPTY_FORM);
    }

    function handleDelete(id) {
        if (!confirm('Sigurado ka bang tatanggalin ang registration na ito?')) return;
        fetch(`api.php?id=${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(() => loadRegistrations());
    }

    return (
        <div className="crud-layout">
            <RegistrationForm
                formData={formData}
                onChange={handleChange}
                onSubmit={handleSubmit}
                editing={!!editingId}
                onCancelEdit={handleCancelEdit}
            />

            <div>
                <h2 style={{ fontSize: '1.1rem' }}>
                    Mga Rehistrado {loading ? '' : `(${list.length})`}
                </h2>
                {loading ? (
                    <p>Naglo-load...</p>
                ) : (
                    <RegistrationList list={list} onEdit={handleEdit} onDelete={handleDelete} />
                )}
            </div>
        </div>
    );
}

ReactDOM.createRoot(document.getElementById('tree-root')).render(<App />);
