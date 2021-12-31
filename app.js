/* import react, {useState} from 'react'
import axios from 'axios'

function app() {

    const [fname,setFname] = useState('');
    const [lname,setLname] = useState('');
    const [username,setUsername] = useState('');
    const [passwd,setPasswd] = useState('');

    const send = e => {
        e.preventDefault();
        axios.post("http://localhost/argh/functions.php", {
            fname: fname,
            lname: lname,
            username: username,
            passwd: passwd
        })
        .catch(e=> console.log(e))
    }

    return (
        <div>
            <form>
                <input value={fname} onChange={e => setFname(e.target.value)}/>
                <input value={lname} onChange={e => setLname(e.target.value)}/>
                <input value={username} onChange={e => setUsername(e.target.value)}/>
                <input value={passwd} onChange={e => setPasswd(e.target.value)}/>
                
                <button onClick={send}>Ok</button>
            </form>
        </div>


    );
}
export default App; */