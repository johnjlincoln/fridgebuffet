import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';

class Home extends Component {
    constructor(props) {
        super(props);
        this.state = {
            test: 'yep'
        };
        this.handleThatThing = this.handleThatThing.bind(this);
    };

    handleThatThing(e) {
        console.log('pew pew');
    };

    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Welcome to Fridgebuffet!</div>
                            <div className="card-body">
                                {this.props.test}{' '} I'm a react component :)
                            </div>
                            <div className="card-body">
                                <button onClick={this.handleThatThing}>Activate Lasers</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Home;

Home.propTypes = {
    test: PropTypes.string
};

Home.defaultProps = {
    test: 'Hellosh'
};

if (document.getElementById('home')) {
    ReactDOM.render(<Home />, document.getElementById('home'));
}
