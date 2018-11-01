<?php
/**
 * @access protected@
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Comment\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use MSBios\Comment\Doctrine\Entity;
use MSBios\Resource\Doctrine\RowStatusableAwareInterface;
use MSBios\Resource\Doctrine\RowStatusableAwareTrait;
use MSBios\Resource\Doctrine\TimestampableAwareInterface;
use MSBios\Resource\Doctrine\TimestampableAwareTrait;

/**
 * Class Comment
 * @package MSBios\Comment\Doctrine\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="cnt_t_comments")
 */
class Comment extends Entity implements
    TimestampableAwareInterface,
    RowStatusableAwareInterface
{
    use TimestampableAwareTrait;
    use RowStatusableAwareTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="refid", type="integer", length=11, nullable=false)
     */
    private $refId;

    /**
     * @var string
     *
     * @ORM\Column(name="reftype", type="string", length=200, nullable=false)
     */
    private $refType;

    /**
     * @var Comment
     *
     * @ORM\ManyToOne(targetEntity="MSBios\Comment\Doctrine\Entity\Comment")
     * @ORM\JoinColumn(name="parentid", referencedColumnName="id", nullable=true)
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=200, nullable=false)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=500, nullable=false)
     */
    private $message;

    /**
     * @var boolean
     *
     * @ORM\Column(name="anonymously", type="boolean", nullable=false)
     */
    private $anonymously = false;

    /**
     * @var string
     *
     * @ORM\Column(name="authorip", type="string", length=100, nullable=false)
     */
    private $authorIp;

    /**
     *
     * @var \DateTime
     *
     * @ORM\Column(name="postdate", type="datetime", nullable=false)
     */
    private $postdate;

    const STATE_NONE = 'NONE';
    const STATE_PUBLISHED = 'PUBLISHED';

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=100, nullable=false)
     */
    private $state = self::STATE_NONE;

    /**
     * @var string
     *
     * @ORM\Column(name="options", type="json_array", nullable=true)
     */
    private $options = [];

    /**
     * Comment constructor.
     * @param null $adapter
     */
    public function __construct($adapter = null)
    {
        parent::__construct($adapter);

        $this->postdate = new \DateTime;
        $this->createdAt = new \DateTime;
        $this->modifiedAt = new \DateTime;
    }

    /**
     * @return int
     */
    public function getRefId(): int
    {
        return $this->refId;
    }

    /**
     * @param int $refId
     */
    public function setRefId(int $refId)
    {
        $this->refId = $refId;
    }

    /**
     * @return string
     */
    public function getRefType(): string
    {
        return $this->refType;
    }

    /**
     * @param string $refType
     */
    public function setRefType(string $refType)
    {
        $this->refType = $refType;
    }

    /**
     * @return Comment
     */
    public function getParent(): Comment
    {
        return $this->parent;
    }

    /**
     * @param Comment $parent
     */
    public function setParent(Comment $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author)
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function isAnonymously(): bool
    {
        return $this->anonymously;
    }

    /**
     * @param bool $anonymously
     */
    public function setAnonymously(bool $anonymously)
    {
        $this->anonymously = $anonymously;
    }

    /**
     * @return string
     */
    public function getAuthorIp(): string
    {
        return $this->authorIp;
    }

    /**
     * @param string $authorIp
     */
    public function setAuthorIp(string $authorIp)
    {
        $this->authorIp = $authorIp;
    }

    /**
     * @return \DateTime
     */
    public function getPostdate(): \DateTime
    {
        return $this->postdate;
    }

    /**
     * @param \DateTime $postdate
     */
    public function setPostdate(\DateTime $postdate)
    {
        $this->postdate = $postdate;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getOptions(): string
    {
        return $this->options;
    }

    /**
     * @param string $options
     */
    public function setOptions(string $options)
    {
        $this->options = $options;
    }
}
