<?php


namespace App\Attr;


use InvalidArgumentException;

class EnumSet extends \MabeEnum\EnumSet
{
    /**
     * The classname of the Enumeration
     * @var string
     */
    protected $enumeration;

    /**
     * Ordinal number of current iterator position
     * @var int
     */
    protected $ordinal = 0;

    /**
     * Highest possible ordinal number
     * @var int
     */
    protected $ordinalMax;

    /**
     * Integer or binary (little endian) bitset
     * @var int|string
     */
    protected $bitset = 0;

    /**#@+
     * Defines protected method names to be called depended of how the bitset type was set too.
     * ... Integer or binary bitset.
     * ... *Int or *Bin method
     *
     * @var string
     */
    protected $fnDoRewind            = 'doRewindInt';
    protected $fnDoCount             = 'doCountInt';
    protected $fnDoGetOrdinals       = 'doGetOrdinalsInt';
    protected $fnDoGetBit            = 'doGetBitInt';
    protected $fnDoSetBit            = 'doSetBitInt';
    protected $fnDoUnsetBit          = 'doUnsetBitInt';
    protected $fnDoGetBinaryBitsetLe = 'doGetBinaryBitsetLeInt';
    protected $fnDoSetBinaryBitsetLe = 'doSetBinaryBitsetLeInt';
    /**#@-*/

    public function __construct($enumeration)
    {
        try {
            parent::__construct($enumeration);
        }
        catch (InvalidArgumentException $exception) {
            if ( ! \is_subclass_of($enumeration, Enum::class)) {
                throw new InvalidArgumentException(\sprintf(
                    "%s can handle subclasses of '%s' only",
                    static::class,
                    Enum::class
                ));
            }

            $this->enumeration = $enumeration;
            $this->ordinalMax  = \count($enumeration::getConstants());

            // By default the bitset is initialized as integer bitset
            // in case the enumeraton has more enumerators then integer bits
            // we will switch this into a binary bitset
            if ($this->ordinalMax > \PHP_INT_SIZE * 8) {
                // init binary bitset with zeros
                $this->bitset = \str_repeat("\0", (int)\ceil($this->ordinalMax / 8));

                // switch internal binary bitset functions
                $this->fnDoRewind            = 'doRewindBin';
                $this->fnDoCount             = 'doCountBin';
                $this->fnDoGetOrdinals       = 'doGetOrdinalsBin';
                $this->fnDoGetBit            = 'doGetBitBin';
                $this->fnDoSetBit            = 'doSetBitBin';
                $this->fnDoUnsetBit          = 'doUnsetBitBin';
                $this->fnDoGetBinaryBitsetLe = 'doGetBinaryBitsetLeBin';
                $this->fnDoSetBinaryBitsetLe = 'doSetBinaryBitsetLeBin';
            }
        }
    }

}
