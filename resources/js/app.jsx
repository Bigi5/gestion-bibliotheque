import React from 'react';
import ReactDOM from 'react-dom/client';
import '../css/app.css';  // Corrige l'importation du fichier CSS

const App = () => {
    return (
        <div>
            <h1 style={{ textAlign: 'center', margin: '20px 0' }}>Bienvenue dans l'application Laravel + React</h1>
            <div style={{ display: 'flex', justifyContent: 'center', gap: '20px', marginTop: '20px' }}>
                <div style={{
                    width: '150px', height: '150px', backgroundColor: '#3498db',
                    borderRadius: '50%', display: 'flex', alignItems: 'center',
                    justifyContent: 'center', color: 'white', fontSize: '20px', fontWeight: 'bold'
                }}>
                    Flottant 1
                </div>
                <div style={{
                    width: '150px', height: '150px', backgroundColor: '#2ecc71',
                    borderRadius: '50%', display: 'flex', alignItems: 'center',
                    justifyContent: 'center', color: 'white', fontSize: '20px', fontWeight: 'bold'
                }}>
                    Flottant 2
                </div>
            </div>
            <div style={{ margin: '40px auto', width: '80%', overflow: 'hidden' }}>
                <marquee style={{ fontSize: '18px', color: '#e74c3c' }}>
                    Bienvenue ! Profitez d'une page moderne avec Laravel + React.
                </marquee>
            </div>
        </div>
    );
};

const root = ReactDOM.createRoot(document.getElementById('app'));
root.render(<App />);
