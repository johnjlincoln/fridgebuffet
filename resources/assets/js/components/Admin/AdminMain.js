import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';

class AdminMain extends Component {
    static propTypes = {
        recentlyLoadedRecipes: PropTypes.object,
        lastRecipePageLoaded: PropTypes.number,
        nextRecipePageToLoad: PropTypes.number,
        lastRecipeLoaded: PropTypes.string,
        nextRecipeToLoad: PropTypes.string,
    };

    static defaultProps = {
        recentlyLoadedRecipes: {},
        lastRecipePageLoaded: null,
        nextRecipePageToLoad: null,
        lastRecipeLoaded: null,
        nextRecipeToLoad: null,
    };

    state = {
        // this component should be stateless
    };

    handleTest = (e) => {
        console.log('test');
    };

    render () {
        return (
            <div>
                <button onClick={this.handleTest}>Activate Lasers</button>
            </div>
        )
    }
}

export default AdminMain;
//
// if (document.getElementById('admin_main')) {
//     ReactDOM.render(<AdminMain />, document.getElementById('admin_main'));
// }
