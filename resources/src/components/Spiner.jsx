import React from 'react';

export const Spiner = ({visible}) => {

    const spinerBox = React.useRef(null);

    React.useEffect(() => {
            setTimeout(() => {
                if (spinerBox.current instanceof HTMLDivElement) {
                    spinerBox.current.classList.add('spiner_box_end');
                }
            }, 100)

    }, [spinerBox.current, visible])

    return visible ? <div className='spiner'>
        <div ref={spinerBox} className='spiner_box'>
            <div className='spiner_ball'></div>
        </div>
    </div>
    : null
}