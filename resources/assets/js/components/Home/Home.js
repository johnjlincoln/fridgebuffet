import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class Home extends Component {
    constructor(props) {
        super(props);
        this.state = {
            comingSoon: 'yep'
        };
    };

    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Welcome to Fridgebuffet!</div>
                            <div className="card-body">
                                We'll have more for you soon! Register now for early access to content!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Home;

if (document.getElementById('home')) {
    const element = document.getElementById('home');
    ReactDOM.render(<Home />, element);
}
