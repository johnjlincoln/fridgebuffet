import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';
import AdminMain from './AdminMain';

class AdminContainer extends Component {
    static propTypes = {
        test: PropTypes.string
    };

    static defaultProps = {
        test: 'string'
    };

    state = {
        test: this.props.test,
        lastRecipePage: 0,
        nextRecipePage: 0,
        nextRecipeId: 0
    };

    handleTest = (e) => {
        console.log('test');
    };

    render () {
        return (
            <div>
                <Grid
                    columnCount={1}
                    columnWidth={100}
                    height={300}
                    rowCount={1}
                    rowHeight={30}
                    width={300}
                    >
                        <AdminMain />
                    </Grid>
                </div>
            )
        }
    }

    export default AdminContainer;

    if (document.getElementById('admin_container')) {
        ReactDOM.render(<AdminContainer />, document.getElementById('admin_container'));
    }
